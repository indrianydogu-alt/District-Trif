@extends('layouts.admin')
@section('title', 'Tambah Voucher')
@section('page_title', 'Tambah Voucher')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.vouchers.store') }}">
            @csrf
            @include('admin.promo.voucher._form')
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
    </div>
</div>

@endsection
