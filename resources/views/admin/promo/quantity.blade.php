@extends('layouts.admin')
@section('title', 'Diskon Otomatis')
@section('page_title', 'Diskon Otomatis (berbasis jumlah item)')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <p class="text-muted">Diskon dihitung dari subtotal. Tier dengan <em>minimum item</em> tertinggi yang masih ≤ total item di keranjang akan dipakai.</p>
        <form method="POST" action="{{ route('admin.quantity-discount.update') }}">
            @csrf
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tier</th>
                            <th>Min. Item</th>
                            <th>Diskon (%)</th>
                            <th>Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiers as $i => $tier)
                        <tr>
                            <td>Tier {{ $i + 1 }}</td>
                            <td>
                                <input type="hidden" name="tiers[{{ $i }}][id]" value="{{ $tier->id }}">
                                <input type="number" min="1" name="tiers[{{ $i }}][min_items]" value="{{ $tier->min_items }}" class="form-control" style="max-width:120px;" required>
                            </td>
                            <td>
                                <input type="number" min="0" max="100" name="tiers[{{ $i }}][discount_percent]" value="{{ $tier->discount_percent }}" class="form-control" style="max-width:120px;" required>
                            </td>
                            <td>
                                <input type="hidden" name="tiers[{{ $i }}][is_active]" value="0">
                                <input type="checkbox" name="tiers[{{ $i }}][is_active]" value="1" {{ $tier->is_active?'checked':'' }} class="form-check-input">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Pengaturan</button>
        </form>
    </div>
</div>

@endsection
