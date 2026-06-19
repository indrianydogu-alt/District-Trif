<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DISTRICT TRIF') - DISTRICT TRIF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Hanken+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased selection:bg-primary-container selection:text-on-primary-container">
@php
    $cartCount = 0;
    if (auth()->check() && auth()->user()->isPembeli()) {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
    }
    $homeUrl = route('home');
@endphp

<nav class="fixed top-0 w-full z-50 bg-surface/70 backdrop-blur-xl border-b border-on-surface/10">
    <div class="vc-container flex justify-between items-center py-5">
        <div class="hidden md:flex space-x-8 items-center">
            <a class="text-primary font-bold border-b border-primary pb-1 text-label-md uppercase tracking-widest transition hover:opacity-80" href="{{ route('home') }}">Home</a>
            <a class="text-on-surface-variant hover:text-on-surface text-label-md uppercase tracking-widest transition" href="{{ route('products.index') }}">Produk</a>
            @auth
                @if(auth()->user()->isPembeli())
                    <a class="text-on-surface-variant hover:text-on-surface text-label-md uppercase tracking-widest transition" href="{{ route('pembeli.orders.index') }}">Pesanan</a>
                @endif
            @endauth
        </div>

        <a class="font-display text-headline-md text-on-surface no-underline hover:opacity-80 transition" href="{{ route('home') }}">DISTRICT TRIF</a>

        <div class="flex items-center space-x-5">
            <form class="hidden lg:flex items-center border-b border-on-surface/20 focus-within:border-primary transition-colors" action="{{ route('products.index') }}" method="GET">
                <input class="bg-transparent border-0 focus:ring-0 text-on-surface placeholder-on-surface-variant/60 text-sm py-1 px-0" type="search" name="search" placeholder="Cari produk" value="{{ request('search') }}">
                <button class="text-primary" type="submit" aria-label="Search">
                    <span class="material-symbols-outlined font-light">search</span>
                </button>
            </form>

            @auth
                @if(auth()->user()->isPembeli())
                    <a class="relative text-on-surface hover:text-primary transition" href="{{ route('pembeli.cart.index') }}" aria-label="Cart">
                        <span class="material-symbols-outlined font-light text-2xl">shopping_bag</span>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 min-w-5 h-5 px-1 rounded-full bg-primary-container text-on-primary-container text-xs flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a class="hidden md:block text-on-surface hover:text-primary transition" href="{{ route('profile.edit') }}" aria-label="Account">
                        <span class="material-symbols-outlined font-light text-2xl">person</span>
                    </a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a class="hidden md:inline-flex text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary no-underline" href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">@csrf
                    <button type="submit" class="text-label-md uppercase tracking-widest text-on-surface-variant hover:text-primary">Logout</button>
                </form>
            @else
                <a class="hidden md:block text-on-surface hover:text-primary transition" href="{{ route('login') }}" aria-label="Account">
                    <span class="material-symbols-outlined font-light text-2xl">person</span>
                </a>
            @endauth

            <button class="text-on-surface hover:text-primary transition md:hidden" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Menu">
                <span class="material-symbols-outlined font-light text-2xl">menu</span>
            </button>
        </div>
    </div>
    <div class="collapse md:hidden border-t border-on-surface/10 bg-surface/95" id="mobileNav">
        <div class="vc-container py-4 flex flex-col gap-4">
            <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('home') }}">Home</a>
            <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('products.index') }}">Produk</a>
            @auth
                @if(auth()->user()->isPembeli())
                    <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('pembeli.orders.index') }}">Orders</a>
                    <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('profile.edit') }}">Account</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="text-label-md uppercase tracking-widest text-primary">Logout</button>
                </form>
            @else
                <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('login') }}">Login</a>
                <a class="text-label-md uppercase tracking-widest no-underline" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>

<main class="min-h-screen pt-28">
    <div class="@yield('main_class', 'vc-container py-10')">
        @include('partials.alerts')
        @yield('content')
    </div>
</main>

<footer class="w-full py-20 bg-surface-container-lowest border-t border-on-surface/5">
    <div class="vc-container grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <div class="md:col-span-4 mb-12 md:mb-0">
            <a class="font-display text-headline-lg text-on-surface block mb-6 hover:opacity-80 transition-opacity no-underline" href="{{ route('home') }}">DISTRICT TRIF</a>
            <p class="vc-body max-w-sm mb-8">Toko online sederhana untuk menemukan dan membeli produk pilihan DISTRICT TRIF.</p>
            <div class="flex flex-col gap-2 mt-8">
                <label class="text-xs uppercase tracking-widest text-on-surface-variant">Info Promo</label>
                <div class="flex border-b border-on-surface/20 focus-within:border-primary transition-colors pb-2 mt-2">
                    <input class="bg-transparent border-none focus:ring-0 text-on-surface w-full placeholder-on-surface-variant/50 p-0" placeholder="Masukkan email" type="email">
                    <button class="text-primary hover:text-on-surface transition-colors" aria-label="Subscribe">
                        <span class="material-symbols-outlined font-light">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="md:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-8 md:pl-12">
            <div class="flex flex-col space-y-4">
                <span class="text-xs uppercase tracking-widest text-on-surface mb-2">Belanja</span>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('home') }}">Home</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('products.index') }}">Produk</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('pembeli.cart.index') }}">Keranjang</a>
            </div>
            <div class="flex flex-col space-y-4">
                <span class="text-xs uppercase tracking-widest text-on-surface mb-2">Akun</span>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('pembeli.orders.index') }}">Pesanan</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('profile.edit') }}">Profil</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('login') }}">Login</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('register') }}">Daftar</a>
            </div>
            <div class="flex flex-col space-y-4 col-span-2 md:col-span-1 mt-8 md:mt-0">
                <span class="text-xs uppercase tracking-widest text-on-surface mb-2">Bantuan</span>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('pembeli.orders.index') }}">Status Pesanan</a>
                <a class="text-on-surface-variant hover:text-tertiary no-underline" href="{{ route('pembeli.cart.index') }}">Keranjang</a>
            </div>
        </div>
        <div class="col-span-1 md:col-span-12 mt-20 pt-8 border-t border-on-surface/5 flex flex-col md:flex-row justify-between items-center text-sm text-on-surface-variant">
            <p>&copy; {{ date('Y') }} DISTRICT TRIF. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a class="hover:text-primary no-underline" href="#">Instagram</a>
                <a class="hover:text-primary no-underline" href="#">Pinterest</a>
                <a class="hover:text-primary no-underline" href="#">Spotify</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
