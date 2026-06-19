<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Voucher;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private function range(Request $request): array
    {
        $from = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
        $to = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
        return [$from, $to];
    }

    public function sales(Request $request)
    {
        [$from, $to] = $this->range($request);
        $rows = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(subtotal) as subtotal'),
                DB::raw('SUM(quantity_discount + voucher_discount) as discount'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totals = [
            'orders' => (int) $rows->sum('orders_count'),
            'subtotal' => (float) $rows->sum('subtotal'),
            'discount' => (float) $rows->sum('discount'),
            'total' => (float) $rows->sum('total'),
        ];

        return $this->respond($request, 'sales', 'Laporan Penjualan', [
            'rows' => $rows, 'totals' => $totals, 'from' => $from, 'to' => $to,
        ]);
    }

    public function topProducts(Request $request)
    {
        [$from, $to] = $this->range($request);
        $rows = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$from, $to])
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as qty'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty')
            ->limit(20)
            ->get();

        return $this->respond($request, 'top-products', 'Laporan Produk Terlaris', [
            'rows' => $rows, 'from' => $from, 'to' => $to,
        ]);
    }

    public function topCustomers(Request $request)
    {
        [$from, $to] = $this->range($request);
        $rows = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$from, $to])
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_price) as total_spent')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        return $this->respond($request, 'top-customers', 'Laporan Pelanggan Teraktif', [
            'rows' => $rows, 'from' => $from, 'to' => $to,
        ]);
    }

    public function vouchers(Request $request)
    {
        [$from, $to] = $this->range($request);
        $usage = Order::whereNotNull('voucher_code')
            ->whereBetween('created_at', [$from, $to])
            ->select(
                'voucher_code',
                DB::raw('COUNT(*) as used_in_orders'),
                DB::raw('SUM(voucher_discount) as total_discount')
            )
            ->groupBy('voucher_code')
            ->orderByDesc('used_in_orders')
            ->get()
            ->keyBy('voucher_code');

        $rows = Voucher::orderBy('code')->get()->map(function ($v) use ($usage) {
            $u = $usage->get($v->code);
            return (object) [
                'code' => $v->code,
                'type' => $v->type,
                'value' => $v->value,
                'max_uses' => $v->max_uses,
                'used_count' => $v->used_count,
                'used_in_period' => $u->used_in_orders ?? 0,
                'total_discount' => (float) ($u->total_discount ?? 0),
                'is_active' => $v->is_active,
            ];
        });

        return $this->respond($request, 'vouchers', 'Laporan Pemakaian Voucher', [
            'rows' => $rows, 'from' => $from, 'to' => $to,
        ]);
    }

    public function shipments(Request $request)
    {
        [$from, $to] = $this->range($request);
        $byStatus = Shipment::whereBetween('created_at', [$from, $to])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $byCourier = Shipment::whereBetween('created_at', [$from, $to])
            ->select('courier', DB::raw('COUNT(*) as total'))
            ->groupBy('courier')
            ->pluck('total', 'courier');

        return $this->respond($request, 'shipments', 'Laporan Pengiriman', [
            'byStatus' => $byStatus,
            'byCourier' => $byCourier,
            'from' => $from,
            'to' => $to,
        ]);
    }

    private function respond(Request $request, string $key, string $title, array $data)
    {
        $export = $request->input('export');

        if ($export === 'excel') {
            $payload = $this->flatten($key, $data);
            return Excel::download(
                new ReportExport($payload['headings'], $payload['rows'], $title),
                "{$key}-".now()->format('Ymd-His').".xlsx"
            );
        }

        if ($export === 'pdf') {
            $payload = $this->flatten($key, $data);
            $pdf = Pdf::loadView('admin.report.pdf', [
                'title' => $title,
                'headings' => $payload['headings'],
                'rows' => $payload['rows'],
                'from' => $data['from'],
                'to' => $data['to'],
            ])->setPaper('a4', 'landscape');
            return $pdf->download("{$key}-".now()->format('Ymd-His').".pdf");
        }

        return view("admin.report.{$key}", $data + ['title' => $title]);
    }

    private function flatten(string $key, array $data): array
    {
        return match ($key) {
            'sales' => [
                'headings' => ['Tanggal', 'Jumlah Order', 'Subtotal', 'Diskon', 'Total'],
                'rows' => $data['rows']->map(fn($r) => [
                    $r->date,
                    $r->orders_count,
                    number_format((float) $r->subtotal, 0, ',', '.'),
                    number_format((float) $r->discount, 0, ',', '.'),
                    number_format((float) $r->total, 0, ',', '.'),
                ])->toArray(),
            ],
            'top-products' => [
                'headings' => ['Produk', 'Qty Terjual', 'Pendapatan'],
                'rows' => $data['rows']->map(fn($r) => [
                    $r->name,
                    $r->qty,
                    number_format((float) $r->revenue, 0, ',', '.'),
                ])->toArray(),
            ],
            'top-customers' => [
                'headings' => ['Nama', 'Email', 'Jumlah Pesanan', 'Total Belanja'],
                'rows' => $data['rows']->map(fn($r) => [
                    $r->name,
                    $r->email,
                    $r->orders_count,
                    number_format((float) $r->total_spent, 0, ',', '.'),
                ])->toArray(),
            ],
            'vouchers' => [
                'headings' => ['Kode', 'Tipe', 'Nilai', 'Total Pakai', 'Pakai Periode', 'Total Diskon'],
                'rows' => $data['rows']->map(fn($r) => [
                    $r->code,
                    $r->type,
                    $r->type === 'percent' ? $r->value.'%' : 'Rp '.number_format((float) $r->value, 0, ',', '.'),
                    $r->used_count.' / '.($r->max_uses ?? '∞'),
                    $r->used_in_period,
                    number_format($r->total_discount, 0, ',', '.'),
                ])->toArray(),
            ],
            'shipments' => [
                'headings' => ['Kategori', 'Nilai', 'Jumlah'],
                'rows' => collect()
                    ->merge($data['byStatus']->map(fn($v, $k) => ['Status', ucfirst($k), $v])->values())
                    ->merge($data['byCourier']->map(fn($v, $k) => ['Kurir', $k, $v])->values())
                    ->toArray(),
            ],
        };
    }
}
