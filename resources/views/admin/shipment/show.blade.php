{{-- resources/views/admin/shipment/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4 gap-2">
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="mb-0 fw-bold">Detail Pengiriman</h4>
        <span class="ms-auto badge {{ $shipment->status_badge }} fs-6">{{ $shipment->status_label }}</span>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Info Pengiriman --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-truck me-2 text-primary"></i>Informasi Pengiriman
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="text-muted small">Kurir</div>
                            <div class="fw-semibold">{{ $shipment->courier }}
                                @if($shipment->service)
                                <span class="text-muted">({{ $shipment->service }})</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Nomor Resi</div>
                            <div class="fw-semibold">{{ $shipment->tracking_number ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Ongkos Kirim</div>
                            <div class="fw-semibold">Rp{{ number_format($shipment->shipping_cost, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Status</div>
                            <span class="badge {{ $shipment->status_badge }}">{{ $shipment->status_label }}</span>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Dibuat</div>
                            <div>{{ $shipment->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        @if($shipment->shipped_at)
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Dikirim</div>
                            <div>{{ $shipment->shipped_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                        @if($shipment->received_at)
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Diterima Customer</div>
                            <div class="fw-semibold text-success">{{ $shipment->received_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Timeline Riwayat --}}
            @if($shipment->order->shipmentHistories->count() > 0)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Pengiriman
                </div>
                <div class="card-body">
                    @foreach($shipment->order->shipmentHistories as $history)
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
                                @if($history->createdBy)
                                · oleh {{ $history->createdBy->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Item Pesanan --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-bag me-2 text-primary"></i>Item Pesanan
                </div>
                <div class="card-body p-0">
                    @foreach($shipment->order->items as $item)
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                            <div class="text-muted small">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="fw-bold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Sidebar Aksi Admin --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-person me-2 text-primary"></i>Info Customer
                </div>
                <div class="card-body small">
                    <div class="fw-semibold">{{ $shipment->order->user->name }}</div>
                    <div class="text-muted">{{ $shipment->order->user->email }}</div>
                    <hr>
                    <div class="text-muted">Alamat:</div>
                    <div>{!! nl2br(e($shipment->order->shipping_address)) !!}</div>
                </div>
            </div>

            {{-- Aksi Admin --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-gear me-2 text-primary"></i>Aksi Admin
                </div>
                <div class="card-body">

                    {{-- Edit info pengiriman --}}
                    <a href="{{ route('admin.shipments.edit', $shipment) }}"
                       class="btn btn-outline-primary w-100 mb-3">
                        <i class="bi bi-pencil me-2"></i>Edit Info Pengiriman
                    </a>

                    {{-- Update ke Processing --}}
                    @if($shipment->status === 'pending')
                    <form action="{{ route('admin.shipments.updateStatus', $shipment) }}" method="POST" class="mb-2">
                        @csrf
                        <input type="hidden" name="status" value="processing">
                        <button type="submit" class="btn btn-warning w-100"
                            onclick="return confirm('Ubah status menjadi Processing?')">
                            <i class="bi bi-gear-fill me-2"></i>Proses Pesanan
                        </button>
                    </form>
                    @endif

                    {{-- Update ke Shipped --}}
                    @if($shipment->status === 'processing')
                    <form action="{{ route('admin.shipments.updateStatus', $shipment) }}" method="POST" class="mb-2">
                        @csrf
                        <input type="hidden" name="status" value="shipped">
                        <button type="submit" class="btn btn-primary w-100"
                            onclick="return confirm('Konfirmasi pesanan telah dikirim?')">
                            <i class="bi bi-truck me-2"></i>Kirim Pesanan
                        </button>
                    </form>
                    @endif

                    {{-- Info: Delivered hanya oleh customer --}}
                    @if($shipment->status === 'shipped')
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Status <strong>Delivered</strong> hanya bisa diubah oleh customer melalui tombol
                        <strong>"Pesanan Diterima"</strong>.
                    </div>
                    @endif

                    @if(in_array($shipment->status, ['delivered', 'completed']))
                    <div class="alert alert-success small mb-0">
                        <i class="bi bi-check-circle me-1"></i>
                        Pesanan telah selesai dan diterima customer.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
