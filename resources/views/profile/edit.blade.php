@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')

<h3 class="mb-3"><i class="bi bi-person-circle"></i> Profil Saya</h3>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Informasi Profil</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success ms-3"><i class="bi bi-check-circle"></i> Profil diperbarui.</span>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Ubah Password</strong></div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-control" required>
                @error('current_password', 'updatePassword')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
                @error('password', 'updatePassword')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
            @if (session('status') === 'password-updated')
                <span class="text-success ms-3"><i class="bi bi-check-circle"></i> Password berhasil diubah.</span>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm border-danger">
    <div class="card-header bg-white text-danger"><strong>Hapus Akun</strong></div>
    <div class="card-body">
        <p class="text-muted">Akun yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin sebelum melanjutkan.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun?')">
            @csrf @method('DELETE')
            <div class="mb-3">
                <label class="form-label">Konfirmasi dengan password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password', 'userDeletion')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <button type="submit" class="btn btn-danger">Hapus Akun</button>
        </form>
    </div>
</div>

@endsection
