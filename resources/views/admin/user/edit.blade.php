@extends('layouts.admin')
@section('title', 'Edit Pelanggan')
@section('page_title', 'Edit Pelanggan')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6 class="mb-0">{{ $user->name }} <small class="text-muted">({{ $user->email }})</small></h6>
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.user._form', ['user' => $user])
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection
