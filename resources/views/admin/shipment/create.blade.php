@extends('layouts.admin')
@section('title', 'Buat Pengiriman')
@section('page_title', 'Buat Pengiriman')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.shipments.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($orders->isEmpty())
            <div class="alert alert-info mb-0">
                Belum ada order yang sudah dibayar dan belum punya pengiriman.
            </div>
        @else
        <form method="POST" action="{{ route('admin.shipments.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Order</label>
                <select name="order_id" id="orderSelect" class="form-select @error('order_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Order --</option>
                    @foreach($orders as $order)
                        <option
                            value="{{ $order->id }}"
                            data-order-number="{{ $order->order_code }}"
                            data-kurir="{{ $order->shipping_courier }}"
                            data-layanan="{{ $order->shipping_service }}"
                            data-biaya="{{ $order->shipping_cost }}"
                            {{ old('order_id')==$order->id?'selected':'' }}
                        >
                            {{ $order->order_code }} - {{ $order->user->name ?? '-' }} (Rp {{ number_format($order->total_price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                <div class="form-text" id="orderNumberInfo">Nomor Order: -</div>
                @error('order_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kurir</label>
                    <select name="courier" id="courierInput" class="form-select @error('courier') is-invalid @enderror" required>
                        <option value="">-- Pilih Kurir --</option>
                        @foreach($couriers as $c)
                            <option value="{{ $c }}" {{ old('courier')===$c?'selected':'' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="courierHidden">
                    @error('courier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Layanan <small class="text-muted">(opsional)</small></label>
                    <input type="text" name="service" id="serviceInput" class="form-control @error('service') is-invalid @enderror" value="{{ old('service') }}" placeholder="REG / YES / OKE">
                    <input type="hidden" id="serviceHidden">
                    @error('service') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Resi <small class="text-muted">(opsional, bisa diisi nanti)</small></label>
                    <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" value="{{ old('tracking_number') }}">
                    @error('tracking_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="shipping_cost" id="shippingCostInput" min="0" step="0.01" class="form-control @error('shipping_cost') is-invalid @enderror" value="{{ old('shipping_cost', 0) }}" required>
                    @error('shipping_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const orderSelect = document.getElementById('orderSelect');
    const orderNumberInfo = document.getElementById('orderNumberInfo');
    const courierInput = document.getElementById('courierInput');
    const courierHidden = document.getElementById('courierHidden');
    const serviceInput = document.getElementById('serviceInput');
    const serviceHidden = document.getElementById('serviceHidden');
    const shippingCostInput = document.getElementById('shippingCostInput');

    const setAutoField = (visibleInput, hiddenInput, name, value) => {
        if (value) {
            visibleInput.value = value;
            visibleInput.disabled = true;
            visibleInput.classList.add('bg-light');
            visibleInput.removeAttribute('name');
            hiddenInput.name = name;
            hiddenInput.value = value;
            return;
        }

        visibleInput.disabled = false;
        visibleInput.classList.remove('bg-light');
        visibleInput.name = name;
        hiddenInput.removeAttribute('name');
        hiddenInput.value = '';
    };

    const setShippingCost = (value, hasOrder) => {
        shippingCostInput.value = value !== '' ? value : 0;
        shippingCostInput.readOnly = hasOrder && value !== '';
        shippingCostInput.classList.toggle('bg-light', shippingCostInput.readOnly);
    };

    const resetFields = () => {
        orderNumberInfo.textContent = 'Nomor Order: -';
        setAutoField(courierInput, courierHidden, 'courier', '');
        setAutoField(serviceInput, serviceHidden, 'service', '');
        courierInput.value = '';
        serviceInput.value = '';
        setShippingCost(0, false);
    };

    const refreshFromOrder = () => {
        const option = orderSelect.selectedOptions[0];
        if (!option || !orderSelect.value) {
            resetFields();
            return;
        }

        orderNumberInfo.textContent = `Nomor Order: ${option.dataset.orderNumber || '-'}`;
        setAutoField(courierInput, courierHidden, 'courier', option.dataset.kurir || '');
        setAutoField(serviceInput, serviceHidden, 'service', option.dataset.layanan || '');
        setShippingCost(option.dataset.biaya || 0, true);
    };

    orderSelect.addEventListener('change', refreshFromOrder);
    refreshFromOrder();
});
</script>

@endsection
