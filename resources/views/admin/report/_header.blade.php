@php
    $tabs = [
        'admin.reports.sales' => 'Penjualan',
        'admin.reports.top-products' => 'Produk Terlaris',
        'admin.reports.top-customers' => 'Pelanggan Teraktif',
        'admin.reports.vouchers' => 'Voucher',
        'admin.reports.shipments' => 'Pengiriman',
    ];
    $current = request()->route()->getName();
@endphp

<ul class="nav nav-tabs mb-3">
    @foreach($tabs as $route => $label)
        <li class="nav-item">
            <a class="nav-link {{ $current === $route ? 'active' : '' }}" href="{{ route($route) }}">{{ $label }}</a>
        </li>
    @endforeach
</ul>

<form method="GET" class="row g-2 mb-3 align-items-end">
    <div class="col-md-3">
        <label class="form-label small">Dari</label>
        <input type="date" name="from" value="{{ request('from', $from->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label small">Sampai</label>
        <input type="date" name="to" value="{{ request('to', $to->format('Y-m-d')) }}" class="form-control">
    </div>
    <div class="col-md-6 d-flex gap-2">
        <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        <a href="{{ route($current, array_merge(request()->only(['from','to']), ['export'=>'excel'])) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Excel</a>
        <a href="{{ route($current, array_merge(request()->only(['from','to']), ['export'=>'pdf'])) }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
    </div>
</form>
