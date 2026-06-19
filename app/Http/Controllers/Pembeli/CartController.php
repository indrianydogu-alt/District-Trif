<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.category')->where('user_id', auth()->id())->get();
        $total = $carts->sum(fn($c) => $c->quantity * (float) $c->product->price);
        return view('pembeli.cart.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
        $product = Product::findOrFail($data['product_id']);
        $qty = $data['quantity'] ?? 1;

        if ($product->stock < $qty) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newQty = $cart->quantity + $qty;
            if ($product->stock < $newQty) {
                return back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $qty,
            ]);
        }

        return redirect()->route('pembeli.cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        if ($cart->product->stock < $data['quantity']) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }
        $cart->update(['quantity' => $data['quantity']]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
