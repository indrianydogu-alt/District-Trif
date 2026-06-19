@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_code)
@section('page_title', 'Detail Pesanan')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>{{ $order->order_code }} <span class="badge {{ $order->status_badge }} ms-2">{{ $order->status_label }}</span></h5>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Informasi Pembeli</strong></div>
            <div class="card-body">
                <p class="mb-1"><strong>Nama:</strong> {{ $order->user->name ?? '-' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                <p class="mb-1"><strong>Telepon:</strong> {{ $order->user->phone ?? '-' }}</p>
                <p class="mb-1"><strong>Alamat Pengiriman:</strong></p>
                @if($order->shipping_province)
                    <p class="text-muted mb-1">
                        {{ $order->shipping_district }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}
                        ({{ number_format($order->shipping_distance_km, 0, ',', '.') }} km dari Purwokerto)
                    </p>
                @endif
                <p class="text-muted">{!! nl2br(e($order->shipping_address)) !!}</p>
                @if($order->notes)
                    <p class="mb-1"><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Item Pesanan</strong></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr><th colspan="3" class="text-end">Subtotal</th><th>Rp {{ number_format($order->subtotal ?: $order->total_price, 0, ',', '.') }}</th></tr>
                        @if($order->quantity_discount > 0)
                            <tr class="text-success"><th colspan="3" class="text-end">Diskon Otomatis</th><th>- Rp {{ number_format($order->quantity_discount, 0, ',', '.') }}</th></tr>
                        @endif
                        @if($order->voucher_discount > 0)
                            <tr class="text-success"><th colspan="3" class="text-end">Voucher{{ $order->voucher_code ? ' ('.$order->voucher_code.')' : '' }}</th><th>- Rp {{ number_format($order->voucher_discount, 0, ',', '.') }}</th></tr>
                        @endif
                        @if($order->shipping_cost > 0)
                            <tr><th colspan="3" class="text-end">Ongkir</th><th>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</th></tr>
                        @endif
                        <tr><th colspan="3" class="text-end">Total</th><th class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Update Status</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    <select name="status" class="form-select mb-2">
                        @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan'] as $s => $label)
                            <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Pembayaran</strong></div>
            <div class="card-body">
                <p class="mb-1"><strong>Metode:</strong> {{ $order->payment_method }}</p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge {{ $order->payment_badge }}">{{ $order->payment_label }}</span></p>
                @if($order->payment && $order->payment->proof_image)
                    <a href="{{ $order->payment->proof_url }}" target="_blank">
                        <img src="{{ $order->payment->proof_url }}" alt="bukti" class="img-fluid rounded mt-2" style="max-height:200px;">
                    </a>
                @else
                    <p class="text-muted">Belum ada bukti pembayaran.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
