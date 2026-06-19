@extends('layouts.admin')
@section('title', 'Pesanan')
@section('page_title', 'Manajemen Pesanan')
@section('content')

<ul class="nav nav-tabs mb-3">
    @php $statuses = ['all'=>'Semua','pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan']; @endphp
    @foreach($statuses as $key=>$label)
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus===$key?'active':'' }}" href="{{ route('admin.orders.index', ['status'=>$key]) }}">{{ $label }}</a>
        </li>
    @endforeach
</ul>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Pembeli</th><th>Total</th><th>Status</th><th>Pembayaran</th><th>Tanggal</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">{{ $order->order_code }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span></td>
                    <td><span class="badge {{ $order->payment_badge }}">{{ $order->payment_label }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>

@endsection
