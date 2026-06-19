@extends('layouts.app')
@section('title', $product->name)
@section('content')

<nav aria-label="breadcrumb" class="mb-8">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="no-underline">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="no-underline">Produk</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
    <div class="lg:col-span-7 relative overflow-hidden bg-surface-container min-h-[520px]">
        <img src="{{ $product->image_url }}" class="absolute inset-0 w-full h-full object-cover brightness-75 contrast-110" alt="{{ $product->name }}">
        <div class="absolute inset-0 bg-gradient-to-t from-[#121412] via-transparent to-transparent"></div>
        <div class="absolute bottom-8 left-8 right-8">
            <span class="vc-kicker">{{ $product->category->name ?? 'Produk' }}</span>
        </div>
    </div>

    <div class="lg:col-span-5 glass-panel rounded-xl p-8 md:p-10">
        <span class="vc-kicker block mb-4">DISTRICT TRIF</span>
        <h1 class="font-display text-headline-lg text-on-surface mb-4">{{ $product->name }}</h1>
        <div class="font-display text-headline-md text-primary mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        <div class="flex items-center gap-3 mb-8">
            <span class="text-on-surface-variant">Stok</span>
            @if($product->stock > 0)
                <span class="badge bg-success">{{ $product->stock }} tersedia</span>
            @else
                <span class="badge bg-danger">Habis</span>
            @endif
        </div>

        <div class="border-t border-on-surface/10 pt-8">
            <h2 class="vc-kicker mb-3">Deskripsi</h2>
            <p class="vc-body">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        @auth
            @if(auth()->user()->isPembeli() && $product->stock > 0)
                <form method="POST" action="{{ route('pembeli.cart.store') }}" class="mt-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-4">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="max-width:120px;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        Tambah ke Keranjang <span class="material-symbols-outlined">arrow_right_alt</span>
                    </button>
                </form>
            @elseif($product->stock <= 0)
                <button class="btn btn-outline-secondary btn-lg mt-10" disabled>Stok Habis</button>
            @else
                <div class="alert alert-warning mt-8">Login sebagai pembeli untuk membeli produk.</div>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-10 no-underline">
                Login untuk Beli <span class="material-symbols-outlined">arrow_right_alt</span>
            </a>
        @endauth
    </div>
</section>

@if($related->count() > 0)
<section class="vc-section">
    <div class="mb-10">
        <span class="vc-kicker block mb-3">Produk Terkait</span>
        <h2 class="font-display text-headline-lg text-on-surface">Produk Lainnya</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        @foreach($related as $p)
            <a href="{{ route('products.show', $p->slug) }}" class="group relative min-h-[340px] overflow-hidden bg-surface-container flex items-end no-underline">
                <img src="{{ $p->image_url }}" class="absolute inset-0 w-full h-full object-cover brightness-75 group-hover:brightness-90 group-hover:scale-105 transition duration-700" alt="{{ $p->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121412] via-[#121412]/20 to-transparent opacity-90"></div>
                <div class="relative z-10 p-6">
                    <h3 class="font-display text-headline-md text-on-surface mb-1">{{ $p->name }}</h3>
                    <div class="text-primary">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

@endsection
