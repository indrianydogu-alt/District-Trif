@extends('layouts.admin')
@section('title', $title)
@section('page_title', $title)
@section('content')

@include('admin.report._header')

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Pemakaian Voucher (jumlah order)</strong></div>
    <div class="card-body"><canvas id="voucherChart" height="80"></canvas></div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Total Pakai (semua waktu)</th>
                    <th>Pakai di Periode</th>
                    <th>Total Diskon (periode)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $r)
                <tr>
                    <td class="fw-semibold">{{ $r->code }}</td>
                    <td>{{ $r->type === 'percent' ? 'Persen' : 'Nominal' }}</td>
                    <td>{{ $r->type === 'percent' ? number_format($r->value, 0).'%' : 'Rp '.number_format((float)$r->value, 0, ',', '.') }}</td>
                    <td>{{ $r->used_count }} / {{ $r->max_uses ?? '∞' }}</td>
                    <td>{{ $r->used_in_period }}</td>
                    <td>Rp {{ number_format($r->total_discount, 0, ',', '.') }}</td>
                    <td>@if($r->is_active) <span class="badge bg-success">Aktif</span> @else <span class="badge bg-secondary">Nonaktif</span> @endif</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada voucher.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('voucherChart'), {
    type: 'bar',
    data: {
        labels: @json($rows->pluck('code')),
        datasets: [{
            label: 'Pakai di Periode',
            data: @json($rows->pluck('used_in_period')),
            backgroundColor: '#6f42c1',
        }]
    },
    options: { responsive: true }
});
</script>
@endpush

@endsection
