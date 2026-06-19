@extends('layouts.admin')
@section('title', $title)
@section('page_title', $title)
@section('content')

@include('admin.report._header')

<div class="row mb-3">
    <div class="col-md-3"><div class="card stat-card"><div class="card-body"><small class="text-muted">Jumlah Order</small><h4 class="mb-0">{{ $totals['orders'] }}</h4></div></div></div>
    <div class="col-md-3"><div class="card stat-card"><div class="card-body"><small class="text-muted">Subtotal</small><h4 class="mb-0">Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</h4></div></div></div>
    <div class="col-md-3"><div class="card stat-card"><div class="card-body"><small class="text-muted">Total Diskon</small><h4 class="mb-0 text-warning">Rp {{ number_format($totals['discount'], 0, ',', '.') }}</h4></div></div></div>
    <div class="col-md-3"><div class="card stat-card"><div class="card-body"><small class="text-muted">Total Pendapatan</small><h4 class="mb-0 text-success">Rp {{ number_format($totals['total'], 0, ',', '.') }}</h4></div></div></div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Grafik Penjualan Harian</strong></div>
    <div class="card-body"><canvas id="salesChart" height="80"></canvas></div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Tanggal</th><th>Order</th><th>Subtotal</th><th>Diskon</th><th>Total</th></tr>
            </thead>
            <tbody>
                @forelse($rows as $r)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($r->date)->format('d M Y') }}</td>
                    <td>{{ $r->orders_count }}</td>
                    <td>Rp {{ number_format((float) $r->subtotal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format((float) $r->discount, 0, ',', '.') }}</td>
                    <td class="fw-semibold">Rp {{ number_format((float) $r->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($rows->pluck('date')),
        datasets: [{
            label: 'Total Penjualan',
            data: @json($rows->pluck('total')),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,.15)',
            tension: .3,
            fill: true,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: true } } }
});
</script>
@endpush

@endsection
