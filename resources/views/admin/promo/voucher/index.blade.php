@extends('layouts.admin')
@section('title', 'Voucher')
@section('page_title', 'Daftar Voucher')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <div></div>
    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Voucher</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Min. Belanja</th>
                    <th>Pemakaian</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $v)
                <tr>
                    <td class="fw-semibold">{{ $v->code }}</td>
                    <td>{{ $v->type === 'percent' ? 'Persen' : 'Nominal' }}</td>
                    <td>
                        @if($v->type === 'percent')
                            {{ number_format($v->value, 0) }}%
                        @else
                            Rp {{ number_format($v->value, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>Rp {{ number_format($v->min_purchase, 0, ',', '.') }}</td>
                    <td>{{ $v->used_count }} / {{ $v->max_uses ?? '∞' }}</td>
                    <td class="small">
                        {{ $v->starts_at ? $v->starts_at->format('d M Y') : '—' }}
                        s.d.
                        {{ $v->ends_at ? $v->ends_at->format('d M Y') : '—' }}
                    </td>
                    <td>
                        @if($v->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.vouchers.edit', $v) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.vouchers.destroy', $v) }}" class="d-inline" onsubmit="return confirm('Hapus voucher {{ $v->code }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada voucher.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $vouchers->links() }}</div>

@endsection
