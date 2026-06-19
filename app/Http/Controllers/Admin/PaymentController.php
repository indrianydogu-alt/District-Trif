<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('order.user')->latest();
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $payments = $query->paginate(15)->withQueryString();
        $activeStatus = $request->status ?? 'all';
        return view('admin.payment.index', compact('payments', 'activeStatus'));
    }

    public function confirm(Payment $payment)
    {
        $payment->update(['status' => 'confirmed']);
        if ($payment->order) {
            $payment->order->update(['payment_status' => 'paid', 'status' => 'processing']);
        }
        return back()->with('success', 'Pembayaran dikonfirmasi.');
    }

    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        if ($payment->order) {
            $payment->order->update(['payment_status' => 'rejected']);
        }
        return back()->with('success', 'Pembayaran ditolak.');
    }
}
