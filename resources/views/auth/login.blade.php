@extends('layouts.guest')
@section('title', 'Login')
@section('content')

<h4 class="text-center mb-4">Masuk ke Akun Anda</h4>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>
    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
    <div class="text-center mt-3">
        <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
    </div>
    @if (Route::has('password.request'))
        <div class="text-center mt-2">
            <small><a href="{{ route('password.request') }}">Lupa password?</a></small>
        </div>
    @endif
</form>

@endsection
