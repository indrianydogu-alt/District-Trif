@extends('layouts.admin')
@section('title', 'Settings Pembayaran')
@section('page_title', 'Settings Pembayaran')
@section('content')

<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Rekening Bank</strong>
                <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#addBank"><i class="bi bi-plus-circle"></i> Tambah</button>
            </div>
            <div class="collapse" id="addBank">
                <div class="card-body border-bottom bg-light">
                    <form method="POST" action="{{ route('admin.settings.bank.store') }}" class="row g-2">
                        @csrf
                        <div class="col-md-3">
                            <input type="text" name="bank_name" class="form-control" placeholder="Nama Bank" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="account_number" class="form-control" placeholder="Nomor Rekening" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="account_holder" class="form-control" placeholder="Nama Pemilik" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="newActive" checked>
                            <label for="newActive" class="form-check-label ms-1">Aktif</label>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success w-100"><i class="bi bi-check"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Bank</th><th>No. Rekening</th><th>Pemilik</th><th>Aktif</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($banks as $b)
                        <tr>
                            <form method="POST" action="{{ route('admin.settings.bank.update', $b) }}">
                                @csrf @method('PUT')
                                <td><input type="text" name="bank_name" class="form-control form-control-sm" value="{{ $b->bank_name }}" required></td>
                                <td><input type="text" name="account_number" class="form-control form-control-sm" value="{{ $b->account_number }}" required></td>
                                <td><input type="text" name="account_holder" class="form-control form-control-sm" value="{{ $b->account_holder }}" required></td>
                                <td>
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $b->is_active?'checked':'' }}>
                                </td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-save"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.settings.bank.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                                </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada rekening.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>QR Code QRIS</strong></div>
            <div class="card-body text-center">
                @if($setting->qris_image)
                    <img src="{{ $setting->qris_url }}" alt="QRIS" class="img-fluid rounded mb-3" style="max-height:280px;">
                @else
                    <div class="text-muted py-5"><i class="bi bi-qr-code fs-1"></i><br>Belum ada QR Code.</div>
                @endif
                <form method="POST" action="{{ route('admin.settings.qris.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <input type="file" name="qris_image" accept="image/*" class="form-control" required>
                        @error('qris_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-primary w-100"><i class="bi bi-cloud-upload"></i> {{ $setting->qris_image ? 'Ganti' : 'Upload' }} QR Code</button>
                </form>
                <small class="text-muted d-block mt-2">JPG/PNG, maks 250 KB. Disimpan di <code>storage/app/public/qris/</code>.</small>
            </div>
        </div>
    </div>
</div>

@endsection
