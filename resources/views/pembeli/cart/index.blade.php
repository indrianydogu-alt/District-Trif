@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')

<h3 class="mb-3"><i class="bi bi-cart3"></i> Keranjang Belanja</h3>

@if($carts->isEmpty())
    <div class="alert alert-info">Keranjang Anda kosong. <a href="{{ route('products.index') }}">Belanja sekarang</a>.</div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th style="width:160px;">Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $cart)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $cart->product->image_url }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:.4rem;" class="me-3">
                                <div>
                                    <a href="{{ route('products.show', $cart->product->slug) }}" class="text-decoration-none text-dark fw-semibold">{{ $cart->product->name }}</a>
                                    <div><small class="text-muted">Stok: {{ $cart->product->stock }}</small></div>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('pembeli.cart.update', $cart) }}" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="form-control form-control-sm">
                                <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-arrow-clockwise"></i></button>
                            </form>
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('pembeli.cart.destroy', $cart) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item ini?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th colspan="2" class="text-primary fs-5">Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
        <a href="{{ route('pembeli.checkout.show') }}" class="btn btn-primary"><i class="bi bi-bag-check"></i> Checkout</a>
    </div>
@endif

@endsection
