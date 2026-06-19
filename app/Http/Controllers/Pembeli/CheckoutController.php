<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Voucher;
use App\Services\PromoCalculator;
use App\Services\ShippingCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalItems = (int) $carts->sum('quantity');
        $subtotal = (float) $carts->sum(fn($c) => $c->quantity * (float) $c->product->price);
        $voucherCode = $request->input('voucher_code') ? strtoupper($request->input('voucher_code')) : null;

        $promo = PromoCalculator::summary($totalItems, $subtotal, $voucherCode);

        return view('pembeli.checkout.show', [
            'carts' => $carts,
            'totalItems' => $totalItems,
            'subtotal' => $subtotal,
            'promo' => $promo,
            'voucherCode' => $voucherCode,
            'shippingOrigin' => ShippingCalculator::origin(),
            'shippingProvinces' => ShippingCalculator::provinces(),
            'couriers' => Shipment::COURIERS,
            'services' => Shipment::SERVICES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_province' => ['required', 'string', Rule::in(ShippingCalculator::provinceNames())],
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_detail' => 'required|string|min:10|max:1000',
            'shipping_courier' => ['required', 'string', Rule::in(Shipment::COURIERS)],
            'shipping_service' => ['required', 'string', Rule::in(Shipment::SERVICES)],
            'payment_method' => 'required|in:Transfer Bank,COD,QRIS',
            'notes' => 'nullable|string',
            'voucher_code' => 'nullable|string|max:50',
        ]);

        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', 'Stok produk ' . $cart->product->name . ' tidak mencukupi.');
            }
        }

        $totalItems = (int) $carts->sum('quantity');
        $subtotal = (float) $carts->sum(fn($c) => $c->quantity * (float) $c->product->price);
        $voucherCode = !empty($data['voucher_code']) ? strtoupper($data['voucher_code']) : null;

        $promo = PromoCalculator::summary($totalItems, $subtotal, $voucherCode);

        if ($voucherCode && $promo['voucher_error']) {
            return back()->withInput()->with('error', $promo['voucher_error']);
        }

        $shipping = ShippingCalculator::forProvince($data['shipping_province']);
        $shippingAddress = implode("\n", [
            $data['shipping_detail'],
            $data['shipping_district'] . ', ' . $data['shipping_city'],
            $data['shipping_province'],
        ]);
        $totalPrice = $promo['total'] + $shipping['cost'];

        $order = DB::transaction(function () use ($carts, $data, $subtotal, $promo, $shipping, $shippingAddress, $totalPrice) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . time() . '-' . random_int(1000, 9999),
                'subtotal' => $subtotal,
                'quantity_discount' => $promo['quantity_discount'],
                'voucher_code' => $promo['voucher']?->code,
                'voucher_discount' => $promo['voucher_discount'],
                'total_price' => $totalPrice,
                'status' => 'pending_payment',
                'shipping_address' => $shippingAddress,
                'shipping_province' => $data['shipping_province'],
                'shipping_city' => $data['shipping_city'],
                'shipping_district' => $data['shipping_district'],
                'shipping_detail' => $data['shipping_detail'],
                'shipping_distance_km' => $shipping['distance_km'],
                'shipping_cost' => $shipping['cost'],
                'shipping_courier' => $data['shipping_courier'],
                'shipping_service' => $data['shipping_service'],
                'payment_method' => $data['payment_method'],
                'payment_status' => 'unpaid',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
                $cart->product->decrement('stock', $cart->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'method' => $data['payment_method'],
                'status' => 'pending',
            ]);

            if ($promo['voucher']) {
                Voucher::where('id', $promo['voucher']->id)->increment('used_count');
            }

            Cart::where('user_id', auth()->id())->delete();

            return $order;
        });

        return redirect()->route('pembeli.payment.upload', $order->id)
            ->with('success', 'Pesanan dibuat. Silakan upload bukti pembayaran.');
    }
}
