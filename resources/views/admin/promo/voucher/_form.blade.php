@php $isEdit = isset($voucher); @endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kode Voucher</label>
        <input type="text" name="code" class="form-control text-uppercase @error('code') is-invalid @enderror" value="{{ old('code', $voucher->code ?? '') }}" required>
        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Tipe</label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="percent" {{ old('type', $voucher->type ?? '')==='percent'?'selected':'' }}>Persen (%)</option>
            <option value="fixed" {{ old('type', $voucher->type ?? '')==='fixed'?'selected':'' }}>Nominal (Rp)</option>
        </select>
        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Nilai</label>
        <input type="number" step="0.01" min="0" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $voucher->value ?? '') }}" required>
        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Min. Belanja</label>
        <input type="number" step="0.01" min="0" name="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" value="{{ old('min_purchase', $voucher->min_purchase ?? 0) }}">
        @error('min_purchase') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Kuota Pemakaian <small class="text-muted">(kosong = unlimited)</small></label>
        <input type="number" min="1" name="max_uses" class="form-control @error('max_uses') is-invalid @enderror" value="{{ old('max_uses', $voucher->max_uses ?? '') }}">
        @error('max_uses') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label d-block">Status</label>
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" id="isActive" class="form-check-input" {{ old('is_active', $voucher->is_active ?? true)?'checked':'' }}>
        <label for="isActive" class="form-check-label ms-1">Aktif</label>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Mulai Berlaku</label>
        <input type="datetime-local" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror" value="{{ old('starts_at', isset($voucher->starts_at)?$voucher->starts_at->format('Y-m-d\TH:i'):'') }}">
        @error('starts_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Berakhir</label>
        <input type="datetime-local" name="ends_at" class="form-control @error('ends_at') is-invalid @enderror" value="{{ old('ends_at', isset($voucher->ends_at)?$voucher->ends_at->format('Y-m-d\TH:i'):'') }}">
        @error('ends_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
