@extends('layouts.admin')
@section('title', $title)
@section('page_title', $title)
@section('content')

@include('admin.report._header')

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Top 10 Pelanggan (total belanja)</strong></div>
    <div class="card-body"><canvas id="topCustomerChart" height="80"></canvas></div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Pesanan</th><th>Total Belanja</th></tr>
            </thead>
            <tbody>
                @forelse($rows as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $r->name }}</td>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->orders_count }}</td>
                    <td>Rp {{ number_format((float) $r->total_spent, 0, ',', '.') }}</td>
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
new Chart(document.getElementById('topCustomerChart'), {
    type: 'bar',
    data: {
        labels: @json($rows->take(10)->pluck('name')),
        datasets: [{
            label: 'Total Belanja (Rp)',
            data: @json($rows->take(10)->pluck('total_spent')),
            backgroundColor: '#198754',
        }]
    },
    options: { responsive: true, indexAxis: 'y' }
});
</script>
@endpush

@endsection
