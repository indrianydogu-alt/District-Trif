@extends('layouts.admin')
@section('title', 'Edit Voucher')
@section('page_title', 'Edit Voucher')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6 class="mb-0">Kode: <strong>{{ $voucher->code }}</strong></h6>
    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.vouchers.update', $voucher) }}">
            @csrf
            @method('PUT')
            @include('admin.promo.voucher._form', ['voucher' => $voucher])
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection
