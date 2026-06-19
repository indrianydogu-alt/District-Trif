@php $isEdit = !is_null($user); @endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Password {{ $isEdit ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $isEdit ? '' : 'required' }}>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone ?? '') }}">
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Kota</label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $user->city ?? '') }}">
        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address ?? '') }}</textarea>
        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postal_code" maxlength="10" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code', $user->postal_code ?? '') }}">
        @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
