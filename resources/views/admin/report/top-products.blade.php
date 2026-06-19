@extends('layouts.admin')
@section('title', $title)
@section('page_title', $title)
@section('content')

@include('admin.report._header')

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Top 10 Produk (qty terjual)</strong></div>
    <div class="card-body"><canvas id="topProductChart" height="80"></canvas></div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Produk</th><th>Qty Terjual</th><th>Pendapatan</th></tr>
            </thead>
            <tbody>
                @forelse($rows as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $r->name }}</td>
                    <td>{{ $r->qty }}</td>
                    <td>Rp {{ number_format((float) $r->revenue, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada data pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('topProductChart'), {
    type: 'bar',
    data: {
        labels: @json($rows->take(10)->pluck('name')),
        datasets: [{
            label: 'Qty Terjual',
            data: @json($rows->take(10)->pluck('qty')),
            backgroundColor: '#0d6efd',
        }]
    },
    options: { responsive: true, indexAxis: 'y' }
});
</script>
@endpush

@endsection
