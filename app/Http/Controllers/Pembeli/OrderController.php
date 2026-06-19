<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShipmentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('pembeli.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('items.product', 'payment', 'shipment', 'shipmentHistories');
        return view('pembeli.order.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        if (!in_array($order->status, ['pending_payment', 'paid'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product?->increment('stock', $item->quantity);
            }
            $order->update(['status' => 'cancelled']);

            ShipmentHistory::create([
                'order_id'    => $order->id,
                'status'      => 'cancelled',
                'description' => 'Pesanan dibatalkan oleh customer.',
                'created_by'  => auth()->id(),
            ]);
        });

        return back()->with('success', 'Pesanan dibatalkan.');
    }

    /**
     * Customer menekan tombol "Pesanan Diterima"
     * Hanya bisa ketika status shipment = shipped
     */
    public function confirmReceived(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $shipment = $order->shipment;

        if (!$shipment || $shipment->status !== 'shipped') {
            return back()->with('error', 'Pesanan belum dapat dikonfirmasi penerimaan.');
        }

        DB::transaction(function () use ($order, $shipment) {
            $now = now();

            // Update shipment
            $shipment->update([
                'status'      => 'delivered',
                'delivered_at'=> $now,
                'received_at' => $now,
            ]);

            // Update order menjadi completed
            $order->update(['status' => 'completed']);

            // Catat riwayat
            ShipmentHistory::create([
                'order_id'    => $order->id,
                'status'      => 'completed',
                'description' => 'Pesanan telah diterima oleh customer pada ' . $now->format('d M Y, H:i') . ' WIB.',
                'created_by'  => auth()->id(),
            ]);
        });

        return back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
    }
}
