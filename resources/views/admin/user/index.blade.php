@extends('layouts.admin')
@section('title', 'Pelanggan')
@section('page_title', 'Daftar Pelanggan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex" style="max-width:400px;width:100%;">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari nama / email / telepon" value="{{ $q ?? '' }}">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Pelanggan</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Kota</th>
                    <th>Pesanan</th>
                    <th>Terdaftar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone ?? '-' }}</td>
                    <td>{{ $u->city ?? '-' }}</td>
                    <td>{{ $u->orders_count }}</td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada pelanggan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>

@endsection
