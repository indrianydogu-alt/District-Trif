@extends('layouts.admin')
@section('title', $title)
@section('page_title', $title)
@section('content')

@include('admin.report._header')

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Pengiriman per Status</strong></div>
            <div class="card-body"><canvas id="statusChart" height="120"></canvas></div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Status</th><th>Jumlah</th></tr></thead>
                    <tbody>
                        @forelse($byStatus as $status => $count)
                            <tr><td>{{ ucfirst($status) }}</td><td>{{ $count }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted py-4">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Pengiriman per Kurir</strong></div>
            <div class="card-body"><canvas id="courierChart" height="120"></canvas></div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Kurir</th><th>Jumlah</th></tr></thead>
                    <tbody>
                        @forelse($byCourier as $c => $count)
                            <tr><td>{{ $c }}</td><td>{{ $count }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted py-4">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: @json($byStatus->keys()),
        datasets: [{
            data: @json($byStatus->values()),
            backgroundColor: ['#ffc107','#0dcaf0','#0d6efd','#198754','#dc3545','#6c757d'],
        }]
    }
});
new Chart(document.getElementById('courierChart'), {
    type: 'doughnut',
    data: {
        labels: @json($byCourier->keys()),
        datasets: [{
            data: @json($byCourier->values()),
            backgroundColor: ['#0d6efd','#dc3545','#fd7e14','#20c997','#6610f2'],
        }]
    }
});
</script>
@endpush

@endsection
