@extends('layouts.admin')
@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')
@section('page_title', $product->exists ? 'Edit Produk' : 'Tambah Produk')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @if($product->exists) @method('PUT') @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        @if($product->image)
                            <div class="mb-2"><img src="{{ $product->image_url }}" alt="" class="img-fluid rounded"></div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control">
                        <small class="text-muted">Maks 1 MB.</small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Produk Aktif</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
