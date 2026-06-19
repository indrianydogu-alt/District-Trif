@extends('layouts.admin')
@section('title', 'Kategori')
@section('page_title', 'Manajemen Kategori')
@section('content')

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Slug</th><th>Jumlah Produk</th><th>Deskripsi</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                <tr>
                    <td>{{ $categories->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $cat->name }}</td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td>{{ $cat->products_count }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($cat->description, 60) }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kategori ini?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $categories->links() }}</div>

@endsection
