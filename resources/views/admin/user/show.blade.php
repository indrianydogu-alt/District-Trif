@extends('layouts.admin')
@section('title', 'Detail Pelanggan')
@section('page_title', 'Detail Pelanggan')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>{{ $user->name }} <small class="text-muted">({{ $user->email }})</small></h5>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Profil</strong></div>
            <div class="card-body">
                <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="mb-1"><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
                <p class="mb-1"><strong>Alamat:</strong></p>
                <p class="text-muted mb-1">{{ $user->address ?? '-' }}</p>
                <p class="mb-1"><strong>Kota:</strong> {{ $user->city ?? '-' }}</p>
                <p class="mb-1"><strong>Kode Pos:</strong> {{ $user->postal_code ?? '-' }}</p>
                <p class="mb-0 text-muted small mt-2">Terdaftar: {{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Statistik</strong></div>
            <div class="card-body">
                <p class="mb-1"><strong>Total Pesanan:</strong> {{ $stats['total_orders'] }}</p>
                <p class="mb-1"><strong>Total Belanja (paid):</strong> Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                <p class="mb-0"><strong>Pesanan Terakhir:</strong> {{ $stats['last_order_at'] ? \Carbon\Carbon::parse($stats['last_order_at'])->format('d M Y H:i') : '-' }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pelanggan ini? Semua data terkait ikut terhapus.')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Hapus Pelanggan</button>
        </form>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Riwayat Pembelian</strong></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Bayar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_code }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->items->sum('quantity') }} pcs</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                            <td><span class="badge {{ $order->payment_badge }}">{{ $order->payment_label }}</span></td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Lihat</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</div>

@endsection
