@extends('layouts.admin')
@section('title', 'Produk')
@section('page_title', 'Manajemen Produk')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <form class="d-flex" method="GET">
        <input type="search" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Produk</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($products as $i => $p)
                <tr>
                    <td>{{ $products->firstItem() + $i }}</td>
                    <td><img src="{{ $p->image_url }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:.4rem;"></td>
                    <td class="fw-semibold">{{ $p->name }}</td>
                    <td><small class="text-muted">{{ $p->category->name ?? '-' }}</small></td>
                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>
                        @if($p->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>

@endsection
