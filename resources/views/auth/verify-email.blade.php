@extends('layouts.guest')
@section('title', 'Verifikasi Email')
@section('content')

<p>Terima kasih telah mendaftar! Silakan verifikasi email Anda dengan link yang telah kami kirimkan.</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert alert-success">Link verifikasi baru telah dikirim.</div>
@endif

<form method="POST" action="{{ route('verification.send') }}" class="mb-2">
    @csrf
    <button type="submit" class="btn btn-primary w-100">Kirim Ulang Email Verifikasi</button>
</form>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
</form>

@endsection
