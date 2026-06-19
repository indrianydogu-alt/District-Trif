@extends('layouts.admin')
@section('title', 'Edit Pengiriman')
@section('page_title', 'Edit Pengiriman')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6 class="mb-0">Order: <strong>{{ $shipment->order->order_code }}</strong> - {{ $shipment->order->user->name ?? '-' }}</h6>
    <a href="{{ route('admin.shipments.show', $shipment) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.shipments.update', $shipment) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kurir</label>
                    <select name="courier" class="form-select @error('courier') is-invalid @enderror" required>
                        @foreach($couriers as $c)
                            <option value="{{ $c }}" {{ old('courier', $shipment->courier)===$c?'selected':'' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('courier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Layanan</label>
                    <input type="text" name="service" class="form-control @error('service') is-invalid @enderror" value="{{ old('service', $shipment->service) }}">
                    @error('service') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Resi</label>
                    <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" value="{{ old('tracking_number', $shipment->tracking_number) }}">
                    @error('tracking_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="shipping_cost" min="0" step="0.01" class="form-control @error('shipping_cost') is-invalid @enderror" value="{{ old('shipping_cost', $shipment->shipping_cost) }}" required>
                    @error('shipping_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $shipment->notes) }}</textarea>
                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection
