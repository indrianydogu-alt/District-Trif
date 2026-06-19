<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - DISTRICT TRIF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Hanken+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background:#1b110e; }
        .sidebar { min-height:100vh; background:#150c09; color:#f2ded9; padding-top:1rem; position:sticky; top:0; border-right:1px solid rgba(242,222,217,.08); }
        .sidebar a { color:#ddc0b8; text-decoration:none; display:block; padding:.6rem 1rem; border-radius:.125rem; letter-spacing:.02em; }
        .sidebar a:hover, .sidebar a.active { background:#281d1a; color:#ffb59e; }
        .sidebar .brand { color:#fff; font-family:"EB Garamond",serif; padding:.5rem 1rem 1rem; border-bottom:1px solid rgba(242,222,217,.08); margin-bottom:1rem; font-size:1.6rem; line-height:1.1; }
        .sidebar .brand small { display:block; font-family:"Hanken Grotesk",sans-serif; font-weight:400; font-size:.72rem; text-transform:uppercase; letter-spacing:.12em; color:#ddc0b8; margin-top:4px; }
        .topbar { background:#231916; color:#f2ded9; padding:.8rem 1rem; border-bottom:1px solid rgba(242,222,217,.08); }
        .stat-card { border:none; box-shadow:none; }
    </style>
    @stack('styles')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar px-2">
            <div class="brand">
                DISTRICT TRIF
                <small>Admin Panel</small>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Kategori</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Pesanan</a>
            <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="bi bi-credit-card"></i> Pembayaran</a>
            <a href="{{ route('admin.shipments.index') }}" class="{{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}"><i class="bi bi-truck"></i> Pengiriman</a>
            <a href="{{ route('admin.quantity-discount.index') }}" class="{{ request()->routeIs('admin.quantity-discount.*') ? 'active' : '' }}"><i class="bi bi-percent"></i> Diskon Otomatis</a>
            <a href="{{ route('admin.vouchers.index') }}" class="{{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}"><i class="bi bi-ticket-perforated"></i> Voucher</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Pengguna</a>
            <a href="{{ route('admin.reports.sales') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i> Laporan</a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Settings</a>
            <hr class="my-3 border-secondary">
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> Lihat Toko</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="btn btn-link text-start w-100" style="color:#e5e7eb;text-decoration:none;padding:.6rem 1rem;"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </aside>
        <div class="col-md-10 px-0">
            <div class="topbar d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('page_title', 'Dashboard')</h5>
                <div class="text-muted">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </div>
            </div>
            <div class="p-4">
                @include('partials.alerts')
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
