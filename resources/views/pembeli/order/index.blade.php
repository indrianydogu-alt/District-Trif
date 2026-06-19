@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')

<h3 class="mb-3"><i class="bi bi-receipt"></i> Pesanan Saya</h3>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">{{ $order->order_code }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span></td>
                    <td><span class="badge {{ $order->payment_badge }}">{{ $order->payment_label }}</span></td>
                    <td>
                        <a href="{{ route('pembeli.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>

@endsection
