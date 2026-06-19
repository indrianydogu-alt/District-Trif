@extends('layouts.guest')
@section('title', 'Lupa Password')
@section('content')

<h5 class="mb-3">Lupa Password</h5>
<p class="text-muted small">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
    <div class="text-center mt-3"><small><a href="{{ route('login') }}">&larr; Kembali ke Login</a></small></div>
</form>

@endsection
