@extends('layouts.admin')
@section('title', 'Tambah Pelanggan')
@section('page_title', 'Tambah Pelanggan')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.user._form', ['user' => null])
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
    </div>
</div>

@endsection
