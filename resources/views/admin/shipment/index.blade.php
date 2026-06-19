@extends('layouts.admin')
@section('title', 'Pengiriman')
@section('page_title', 'Manajemen Pengiriman')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('admin.shipments.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Buat Pengiriman</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="all" {{ $activeStatus==='all'?'selected':'' }}>Semua Status</option>
            @foreach($statuses as $s)
                <option value="{{ $s }}" {{ $activeStatus===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="courier" class="form-select" onchange="this.form.submit()">
            <option value="all" {{ $activeCourier==='all'?'selected':'' }}>Semua Kurir</option>
            @foreach($couriers as $c)
                <option value="{{ $c }}" {{ $activeCourier===$c?'selected':'' }}>{{ $c }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Pembeli</th>
                    <th>Kurir</th>
                    <th>Resi</th>
                    <th>Ongkir</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($shipments as $shipment)
                <tr>
                    <td class="fw-semibold">{{ $shipment->order->order_code ?? '-' }}</td>
                    <td>{{ $shipment->order->user->name ?? '-' }}</td>
                    <td>{{ $shipment->courier }}{{ $shipment->service ? ' - '.$shipment->service : '' }}</td>
                    <td>{{ $shipment->tracking_number ?? '-' }}</td>
                    <td>Rp {{ number_format($shipment->shipping_cost, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span></td>
                    <td>{{ $shipment->created_at->format('d M Y') }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.shipments.show', $shipment) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada pengiriman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $shipments->links() }}</div>

@endsection
