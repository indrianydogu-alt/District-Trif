@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('page_title', 'Konfirmasi Pembayaran')
@section('content')

<ul class="nav nav-tabs mb-3">
    @php $tabs = ['all'=>'Semua','pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak']; @endphp
    @foreach($tabs as $key => $label)
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus===$key?'active':'' }}" href="{{ route('admin.payments.index', ['status'=>$key]) }}">{{ $label }}</a>
        </li>
    @endforeach
</ul>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode Pesanan</th><th>Pembeli</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td class="fw-semibold">
                        <a href="{{ route('admin.orders.show', $payment->order_id) }}">{{ $payment->order->order_code ?? '-' }}</a>
                    </td>
                    <td>{{ $payment->order->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->method }}</td>
                    <td>
                        @if($payment->proof_image)
                            <a href="{{ $payment->proof_url }}" target="_blank">
                                <img src="{{ $payment->proof_url }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:.4rem;">
                            </a>
                        @else
                            <small class="text-muted">Belum upload</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $payment->status_badge }}">{{ $payment->status_label }}</span>
                    </td>
                    <td class="text-end">
                        @if($payment->status === 'pending' && $payment->proof_image)
                            <form method="POST" action="{{ route('admin.payments.confirm', $payment) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pembayaran ini?')"><i class="bi bi-check"></i> Konfirmasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak pembayaran ini?')"><i class="bi bi-x"></i> Tolak</button>
                            </form>
                        @else
                            <small class="text-muted">-</small>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $payments->links() }}</div>

@endsection
