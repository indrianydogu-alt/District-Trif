@extends('layouts.app')
@section('title', 'Home')
@section('content')

<section class="mb-10">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4">
        <div>
            <span class="vc-kicker d-block mb-3">DISTRICT TRIF Store</span>
            <h1 class="font-display text-headline-lg text-on-surface mb-3">Belanja Produk DISTRICT TRIF</h1>
            <p class="vc-body mb-0">Pilih produk, masukkan ke keranjang, lalu checkout dengan mudah.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-primary no-underline">
            Lihat Semua Produk
            <span class="material-symbols-outlined">arrow_right_alt</span>
        </a>
    </div>
</section>

@if($categories->count() > 0)
    <section class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="font-display text-headline-md mb-1">Kategori</h2>
                    <p class="vc-body mb-0">Cari produk berdasarkan kategori.</p>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="btn btn-sm btn-outline-primary">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if($featured->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
            <div>
                <h2 class="font-display text-headline-md mb-1">Produk Terbaru</h2>
                <p class="vc-body mb-0">Produk pilihan yang baru ditambahkan.</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featured as $p)
                <div class="col-sm-6 col-lg-3">
                    <article class="card product-card h-100">
                        <a href="{{ route('products.show', $p->slug) }}" class="d-block overflow-hidden">
                            <img src="{{ $p->image_url }}" class="card-img-top w-100" alt="{{ $p->name }}">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <small class="text-muted text-uppercase">{{ $p->category->name ?? '-' }}</small>
                            <h3 class="font-display text-headline-md mt-2 mb-1">
                                <a href="{{ route('products.show', $p->slug) }}" class="text-on-surface no-underline">{{ $p->name }}</a>
                            </h3>
                            <div class="text-primary mb-2">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                            <small class="text-muted mb-3">Stok: {{ $p->stock }}</small>
                            <div class="mt-auto">
                                @auth
                                    @if(auth()->user()->isPembeli())
                                        <form method="POST" action="{{ route('pembeli.cart.store') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button class="btn btn-sm btn-primary w-100" type="submit" @if($p->stock <= 0) disabled @endif>
                                                Tambah
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('products.show', $p->slug) }}" class="btn btn-sm btn-outline-primary w-100">Detail</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary w-100">Login untuk Beli</a>
                                @endauth
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endif

<section>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h2 class="font-display text-headline-md mb-1">Semua Produk</h2>
            <p class="vc-body mb-0">Daftar produk yang tersedia di DISTRICT TRIF.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary no-underline">Lihat katalog</a>
    </div>

    <div class="row g-4">
        @forelse($products as $p)
            <div class="col-sm-6 col-lg-3">
                <article class="card product-card h-100">
                    <a href="{{ route('products.show', $p->slug) }}" class="d-block overflow-hidden">
                        <img src="{{ $p->image_url }}" class="card-img-top w-100" alt="{{ $p->name }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted text-uppercase">{{ $p->category->name ?? '-' }}</small>
                        <h3 class="font-display text-headline-md mt-2 mb-1">
                            <a href="{{ route('products.show', $p->slug) }}" class="text-on-surface no-underline">{{ $p->name }}</a>
                        </h3>
                        <div class="text-primary mb-2">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        <small class="text-muted mb-3">Stok: {{ $p->stock }}</small>
                        <div class="mt-auto">
                            @auth
                                @if(auth()->user()->isPembeli())
                                    <form method="POST" action="{{ route('pembeli.cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $p->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button class="btn btn-sm btn-primary w-100" type="submit" @if($p->stock <= 0) disabled @endif>
                                            Tambah
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('products.show', $p->slug) }}" class="btn btn-sm btn-outline-primary w-100">Detail</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary w-100">Login untuk Beli</a>
                            @endauth
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-on-surface-variant">Belum ada produk.</div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</section>

@endsection
