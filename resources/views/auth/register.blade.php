@extends('layouts.guest')
@section('title', 'Daftar')
@section('content')

<h4 class="text-center mb-4">Daftar Akun Baru</h4>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nomor HP</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Alamat <small class="text-muted">(opsional)</small></label>
        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Daftar</button>
    <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
    </div>
</form>

@endsection
