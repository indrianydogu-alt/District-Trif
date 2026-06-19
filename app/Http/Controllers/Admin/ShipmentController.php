<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShipmentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::with('order.user')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('courier') && $request->courier !== 'all') {
            $query->where('courier', $request->courier);
        }

        $shipments    = $query->paginate(15)->withQueryString();
        $activeStatus = $request->status ?? 'all';
        $activeCourier = $request->courier ?? 'all';

        return view('admin.shipment.index', [
            'shipments'     => $shipments,
            'activeStatus'  => $activeStatus,
            'activeCourier' => $activeCourier,
            'couriers'      => Shipment::COURIERS,
            'statuses'      => Shipment::STATUSES,
        ]);
    }

    public function create()
    {
        $orders = Order::with('user')
            ->where('payment_status', 'paid')
            ->whereDoesntHave('shipment')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->latest()
            ->get();

        return view('admin.shipment.create', [
            'orders'   => $orders,
            'couriers' => Shipment::COURIERS,
        ]);
    }

    public function store(Request $request)
    {
        $baseData = $request->validate([
            'order_id'        => 'required|exists:orders,id|unique:shipments,order_id',
            'tracking_number' => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ]);

        $order = Order::findOrFail($baseData['order_id']);
        $shippingData = $this->shippingDataFromOrder($order);
        $manualData = $this->validateManualShippingFallback($request, $shippingData);

        if ($order->payment_status !== 'paid') {
            return back()->with('error', 'Hanya order yang sudah dibayar yang bisa dibuatkan pengiriman.');
        }

        $data = array_merge($baseData, $manualData, $shippingData);

        DB::transaction(function () use ($data, $order) {
            Shipment::create($data + ['status' => 'pending']);

            // Catat riwayat
            ShipmentHistory::create([
                'order_id'    => $order->id,
                'status'      => 'processing',
                'description' => 'Pesanan dibuat dan siap diproses.',
                'created_by'  => auth()->id(),
            ]);
        });

        return redirect()->route('admin.shipments.index')->with('success', 'Pengiriman berhasil dibuat.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('order.user', 'order.items.product', 'order.shipmentHistories.createdBy');
        return view('admin.shipment.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $shipment->load('order.user');
        return view('admin.shipment.edit', [
            'shipment' => $shipment,
            'couriers' => Shipment::COURIERS,
        ]);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $manualData = $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ]);

        $shippingData = $this->shippingDataFromOrder($shipment->order);
        $data = array_merge(
            $manualData,
            $this->validateManualShippingFallback($request, $shippingData),
            $shippingData
        );

        $shipment->update($data);

        return redirect()->route('admin.shipments.show', $shipment)->with('success', 'Data pengiriman diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('admin.shipments.index')->with('success', 'Pengiriman dihapus.');
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Shipment::ADMIN_ALLOWED_STATUSES),
        ]);

        // Admin TIDAK BOLEH set delivered
        if ($data['status'] === 'delivered') {
            return back()->with('error', 'Status Delivered hanya bisa diubah oleh customer.');
        }

        DB::transaction(function () use ($data, $shipment) {
            $update = ['status' => $data['status']];

            if ($data['status'] === 'shipped' && !$shipment->shipped_at) {
                $update['shipped_at'] = now();
            }

            $shipment->update($update);

            // Update status order
            $orderStatusMap = [
                'processing' => 'processing',
                'shipped'    => 'shipped',
            ];

            if (isset($orderStatusMap[$data['status']])) {
                $shipment->order->update(['status' => $orderStatusMap[$data['status']]]);
            }

            // Catat riwayat
            $descriptionMap = [
                'processing' => 'Pesanan sedang diproses oleh admin.',
                'shipped'    => 'Pesanan telah dikirim ke kurir ' . $shipment->courier . '. No. Resi: ' . ($shipment->tracking_number ?? '-'),
            ];

            ShipmentHistory::create([
                'order_id'    => $shipment->order_id,
                'status'      => $data['status'],
                'description' => $descriptionMap[$data['status']] ?? 'Status diperbarui.',
                'created_by'  => auth()->id(),
            ]);
        });

        return back()->with('success', 'Status pengiriman diperbarui.');
    }

    private function shippingDataFromOrder(Order $order): array
    {
        return array_filter([
            'courier' => $order->shipping_courier,
            'service' => $order->shipping_service,
            'shipping_cost' => $order->shipping_cost,
        ], fn ($value) => $value !== null && $value !== '');
    }

    private function validateManualShippingFallback(Request $request, array $shippingData): array
    {
        $rules = [];

        if (!array_key_exists('courier', $shippingData)) {
            $rules['courier'] = 'required|in:' . implode(',', Shipment::COURIERS);
        }

        if (!array_key_exists('service', $shippingData)) {
            $rules['service'] = 'nullable|string|max:50';
        }

        if (!array_key_exists('shipping_cost', $shippingData)) {
            $rules['shipping_cost'] = 'required|numeric|min:0';
        }

        return $rules ? $request->validate($rules) : [];
    }
}
