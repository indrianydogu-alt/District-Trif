<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function upload(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('payment', 'items.product');

        $banks = $order->payment_method === 'Transfer Bank'
            ? BankAccount::where('is_active', true)->orderBy('bank_name')->get()
            : collect();

        $qris = $order->payment_method === 'QRIS'
            ? PaymentSetting::current()
            : null;

        return view('pembeli.payment.upload', compact('order', 'banks', 'qris'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        $data = $request->validate([
            'proof_image' => 'required|image|max:250',
        ]);

        $path = $request->file('proof_image')->store('payments', 'public');

        $payment = $order->payment;
        if (!$payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_price,
                'method' => $order->payment_method,
                'status' => 'pending',
                'proof_image' => $path,
            ]);
        } else {
            if ($payment->proof_image) {
                Storage::disk('public')->delete($payment->proof_image);
            }
            $payment->update(['proof_image' => $path, 'status' => 'pending']);
        }

        return redirect()->route('pembeli.orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }
}
