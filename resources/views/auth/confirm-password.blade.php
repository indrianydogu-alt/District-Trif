@extends('layouts.guest')
@section('title', 'Konfirmasi Password')
@section('content')

<h5 class="mb-3">Konfirmasi Password</h5>
<p class="text-muted small">Ini adalah area aman. Konfirmasi password Anda sebelum melanjutkan.</p>
<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Konfirmasi</button>
</form>

@endsection
