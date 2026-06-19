@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card text-bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small">Total Produk</div>
                        <h3 class="mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small">Total Pesanan</div>
                        <h3 class="mb-0">{{ $totalOrders }}</h3>
                    </div>
                    <i class="bi bi-receipt fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small">Total Pendapatan</div>
                        <h3 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="small">Pesanan Hari Ini</div>
                        <h3 class="mb-0">{{ $todayOrders }}</h3>
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card stat-card">
            <div class="card-header bg-white"><strong>Grafik Penjualan 7 Hari Terakhir</strong></div>
            <div class="card-body">
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-header bg-white"><strong>Pesanan Terbaru</strong></div>
            <ul class="list-group list-group-flush">
                @forelse($recentOrders as $order)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">{{ $order->order_code }}</a>
                            <span class="badge {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <small class="text-muted">{{ $order->user->name ?? '-' }} &middot; Rp {{ number_format($order->total_price, 0, ',', '.') }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Belum ada pesanan.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($chartData),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,.15)',
                fill: true,
                tension: .3
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endpush
@endsection
