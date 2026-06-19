@extends('layouts.app')
@section('title', 'Upload Bukti Pembayaran')
@section('content')

<h3 class="mb-3"><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h3>

@if($order->payment_method === 'Transfer Bank' && $banks->count())
    <div class="card shadow-sm mb-3 border-primary">
        <div class="card-header bg-primary text-white"><i class="bi bi-bank"></i> Transfer ke Salah Satu Rekening Berikut</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr><th>Bank</th><th>Nomor Rekening</th><th>Atas Nama</th></tr>
                </thead>
                <tbody>
                    @foreach($banks as $b)
                    <tr>
                        <td class="fw-semibold">{{ $b->bank_name }}</td>
                        <td><code class="fs-5">{{ $b->account_number }}</code></td>
                        <td>{{ $b->account_holder }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@elseif($order->payment_method === 'Transfer Bank')
    <div class="alert alert-warning mb-3">Belum ada rekening aktif. Silakan hubungi admin.</div>
@endif

@if($order->payment_method === 'QRIS')
    <div class="card shadow-sm mb-3 border-primary">
        <div class="card-header bg-primary text-white"><i class="bi bi-qr-code"></i> Scan QR Code Berikut</div>
        <div class="card-body text-center">
            @if($qris && $qris->qris_image)
                <img src="{{ $qris->qris_url }}" alt="QRIS" class="img-fluid rounded" style="max-height:320px;">
                <p class="text-muted small mt-2 mb-0">Scan QR di atas dengan aplikasi pembayaran Anda.</p>
            @else
                <div class="alert alert-warning mb-0">QR Code belum tersedia. Silakan hubungi admin.</div>
            @endif
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('pembeli.payment.store', $order) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control" value="{{ $order->payment_method }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total yang harus dibayar</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($order->total_price, 0, ',', '.') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti Transfer / Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="proof_image" accept="image/*" class="form-control" required>
                        <small class="text-muted">Format: JPG/PNG, maks 250 KB.</small>
                    </div>
                    @if($order->payment && $order->payment->proof_image)
                        <div class="mb-3">
                            <label class="form-label">Bukti Saat Ini</label><br>
                            <img src="{{ $order->payment->proof_url }}" alt="" class="img-fluid rounded" style="max-height:200px;">
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary"><i class="bi bi-cloud-upload"></i> Upload</button>
                    <a href="{{ route('pembeli.orders.show', $order) }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Ringkasan Pesanan</strong></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }} x{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        @if($order->shipping_cost > 0)
                        <tr>
                            <td>Ongkir <small class="text-muted">({{ $order->shipping_province }})</small></td>
                            <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Total</th>
                            <th class="text-end text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
