<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $orders = $query->paginate(15)->withQueryString();
        $activeStatus = $request->status ?? 'all';
        return view('admin.order.index', compact('orders', 'activeStatus'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'payment');
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $order->update(['status' => $data['status']]);
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
