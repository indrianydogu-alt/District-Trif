{{-- resources/views/pembeli/order/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('pembeli.orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="mb-0 fw-bold">Detail Pesanan</h4>
        <span class="ms-auto badge {{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TOMBOL PESANAN DITERIMA --}}
    @if($order->shipment && $order->shipment->status === 'shipped')
    <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <i class="bi bi-truck fs-4 me-2"></i>
            <strong>Pesanan Anda sedang dalam pengiriman!</strong>
            <div class="small mt-1">Sudah menerima barang? Klik tombol konfirmasi.</div>
        </div>
        <form action="{{ route('pembeli.orders.confirmReceived', $order) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-lg"
                onclick="return confirm('Konfirmasi bahwa Anda sudah menerima pesanan ini?')">
                <i class="bi bi-check-circle-fill me-2"></i>Pesanan Diterima
            </button>
        </form>
    </div>
    @endif

    <div class="row g-4">

        {{-- Info Pesanan --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold border-bottom">
                    <i class="bi bi-bag me-2 text-primary"></i>Item Pesanan
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                        @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                             class="rounded" style="width:60px;height:60px;object-fit:cover;" alt="">
                        @else
                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                            <div class="text-muted small">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="fw-bold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($order->voucher_discount > 0)
                    <div class="d-flex justify-content-between small text-success mb-1">
                        <span>Diskon Voucher ({{ $order->voucher_code }})</span>
                        <span>- Rp{{ number_format($order->voucher_discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($order->shipping_cost > 0)
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Ongkos Kirim</span>
                        <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between fw-bold border-top pt-2 mt-1">
                        <span>Total</span>
                        <span class="text-primary">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Info Pengiriman --}}
            @if($order->shipment)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold border-bottom">
                    <i class="bi bi-truck me-2 text-primary"></i>Informasi Pengiriman
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="text-muted small">Kurir</div>
                            <div class="fw-semibold">{{ $order->shipment->courier }}
                                @if($order->shipment->service)
                                <span class="text-muted">({{ $order->shipment->service }})</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Nomor Resi</div>
                            <div class="fw-semibold">
                                {{ $order->shipment->tracking_number ?? '<span class="text-muted">Belum tersedia</span>' }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Status Pengiriman</div>
                            <span class="badge {{ $order->shipment->status_badge }}">
                                {{ $order->shipment->status_label }}
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Ongkos Kirim</div>
                            <div class="fw-semibold">Rp{{ number_format($order->shipment->shipping_cost, 0, ',', '.') }}</div>
                        </div>
                        @if($order->shipment->shipped_at)
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Dikirim</div>
                            <div class="fw-semibold">{{ $order->shipment->shipped_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                        @if($order->shipment->received_at)
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Diterima</div>
                            <div class="fw-semibold">{{ $order->shipment->received_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Timeline Riwayat --}}
            @if($order->shipmentHistories->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold border-bottom">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Pesanan
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($order->shipmentHistories as $history)
                        <div class="d-flex gap-3 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center
                                    {{ $loop->last ? 'bg-primary text-white' : 'bg-light text-muted' }}"
                                    style="width:36px;height:36px;min-width:36px;">
                                    <i class="bi {{ $history->status_icon }} small"></i>
                                </div>
                                @if(!$loop->last)
                                <div style="width:2px;height:100%;min-height:20px;background:#dee2e6;margin-top:4px;"></div>
                                @endif
                            </div>
                            <div class="pb-3">
                                <div class="fw-semibold small">{{ $history->description }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">
                                    {{ $history->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold border-bottom">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Info Pesanan
                </div>
                <div class="card-body">
                    <dl class="row small mb-0">
                        <dt class="col-5 text-muted">Kode Pesanan</dt>
                        <dd class="col-7 fw-semibold">{{ $order->order_code }}</dd>
                        <dt class="col-5 text-muted">Tanggal</dt>
                        <dd class="col-7">{{ $order->created_at->format('d M Y') }}</dd>
                        <dt class="col-5 text-muted">Pembayaran</dt>
                        <dd class="col-7">
                            <span class="badge {{ $order->payment_badge }}">{{ $order->payment_label }}</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold border-bottom">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Alamat Pengiriman
                </div>
                <div class="card-body small">
                    @if($order->shipping_province)
                        <div class="mb-2">
                            <div class="text-muted">Wilayah</div>
                            <div class="fw-semibold">{{ $order->shipping_district }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}</div>
                            <div class="text-muted">Jarak dari Purwokerto: {{ number_format($order->shipping_distance_km, 0, ',', '.') }} km</div>
                        </div>
                    @endif
                    {!! nl2br(e($order->shipping_address)) !!}
                </div>
            </div>

            {{-- Tombol Batalkan --}}
            @if(in_array($order->status, ['pending_payment', 'paid']))
            <form action="{{ route('pembeli.orders.cancel', $order) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100"
                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
