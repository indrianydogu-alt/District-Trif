@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('page_title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if($category->exists) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
