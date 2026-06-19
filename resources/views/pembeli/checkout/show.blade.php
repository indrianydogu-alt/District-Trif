@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<section class="mb-10">
    <nav aria-label="breadcrumb" class="mb-6">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="no-underline">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembeli.cart.index') }}" class="no-underline">Keranjang</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <span class="vc-kicker block mb-3">Checkout</span>
            <h1 class="font-display text-headline-lg md:text-display-lg text-on-surface mb-3">Selesaikan Pesanan</h1>
            <p class="vc-body max-w-2xl mb-0">Lengkapi alamat, pilih pengiriman, lalu konfirmasi pesanan arsip pilihanmu.</p>
        </div>
        <div class="grid grid-cols-3 gap-2 min-w-full sm:min-w-[420px]">
            <div class="border border-on-surface/10 bg-surface-container-low p-3">
                <div class="text-primary text-xs uppercase tracking-widest mb-1">01</div>
                <div class="text-on-surface text-sm">Alamat</div>
            </div>
            <div class="border border-on-surface/10 bg-surface-container-low p-3">
                <div class="text-primary text-xs uppercase tracking-widest mb-1">02</div>
                <div class="text-on-surface text-sm">Pembayaran</div>
            </div>
            <div class="border border-primary/40 bg-primary/10 p-3">
                <div class="text-primary text-xs uppercase tracking-widest mb-1">03</div>
                <div class="text-on-surface text-sm">Konfirmasi</div>
            </div>
        </div>
    </div>
</section>

<form method="POST" action="{{ route('pembeli.checkout.store') }}" class="checkout-form">
    @csrf
    <input type="hidden" name="voucher_code" value="{{ $promo['voucher']?->code }}">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
        <div class="lg:col-span-7 space-y-6">
            <section class="glass-panel rounded-xl p-6 md:p-8">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <span class="vc-kicker block mb-2">Voucher</span>
                        <h2 class="font-display text-headline-md text-on-surface mb-1">Kode Promo</h2>
                        <p class="vc-body mb-0">Masukkan voucher sebelum pesanan dikonfirmasi.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary font-light text-3xl">sell</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input form="voucherForm" type="text" name="voucher_code" class="form-control text-uppercase" placeholder="Masukkan kode voucher" value="{{ $voucherCode ?? '' }}">
                    <button form="voucherForm" class="btn btn-outline-primary shrink-0" type="submit">Pakai Voucher</button>
                </div>
                @if($promo['voucher_error'])
                    <div class="text-danger small mt-3">{{ $promo['voucher_error'] }}</div>
                @elseif($promo['voucher'])
                    <div class="text-success small mt-3"><i class="bi bi-check-circle"></i> Voucher <strong>{{ $promo['voucher']->code }}</strong> diterapkan.</div>
                @endif
            </section>

            <section class="glass-panel rounded-xl p-6 md:p-8">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <span class="vc-kicker block mb-2">Pengiriman</span>
                        <h2 class="font-display text-headline-md text-on-surface mb-1">Alamat Pengiriman</h2>
                        <p class="vc-body mb-0">Pilih wilayah agar ongkir dan estimasi jarak terhitung otomatis.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary font-light text-3xl">local_shipping</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select name="shipping_province" id="shippingProvince" class="form-select" required>
                                <option value="">-- Pilih provinsi --</option>
                                @foreach($shippingProvinces as $province => $shipping)
                                    <option
                                        value="{{ $province }}"
                                        data-distance="{{ $shipping['distance_km'] }}"
                                        data-cost="{{ $shipping['cost'] }}"
                                        {{ old('shipping_province') === $province ? 'selected' : '' }}
                                    >
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <select name="shipping_city" id="shippingCity" class="form-select" data-old="{{ old('shipping_city') }}" required>
                            <option value="">-- Pilih kab/kota --</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <select name="shipping_district" id="shippingDistrict" class="form-select" data-old="{{ old('shipping_district') }}" required>
                            <option value="">-- Pilih kecamatan --</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Alamat <span class="text-danger">*</span></label>
                    <textarea name="shipping_detail" rows="3" class="form-control" required placeholder="Nama jalan, nomor rumah, RT/RW, patokan">{{ old('shipping_detail', auth()->user()->address) }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kurir <span class="text-danger">*</span></label>
                        <select name="shipping_courier" class="form-select @error('shipping_courier') is-invalid @enderror" required>
                            <option value="">-- Pilih kurir --</option>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier }}" {{ old('shipping_courier') === $courier ? 'selected' : '' }}>{{ $courier }}</option>
                            @endforeach
                        </select>
                        @error('shipping_courier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Layanan <span class="text-danger">*</span></label>
                        <select name="shipping_service" class="form-select @error('shipping_service') is-invalid @enderror" required>
                            <option value="">-- Pilih layanan --</option>
                            @foreach($services as $service)
                                <option value="{{ $service }}" {{ old('shipping_service') === $service ? 'selected' : '' }}>{{ $service }}</option>
                            @endforeach
                        </select>
                        @error('shipping_service') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="notes" rows="2" class="form-control" placeholder="Instruksi tambahan untuk penjual atau kurir">{{ old('notes') }}</textarea>
                </div>
            </section>

            <section class="glass-panel rounded-xl p-6 md:p-8">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <span class="vc-kicker block mb-2">Pembayaran</span>
                        <h2 class="font-display text-headline-md text-on-surface mb-1">Metode Pembayaran</h2>
                        <p class="vc-body mb-0">Pilih metode yang paling nyaman untuk pesanan ini.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary font-light text-3xl">payments</span>
                </div>
                    <select name="payment_method" class="form-select" required>
                        <option value="">-- Pilih metode --</option>
                        <option value="Transfer Bank" {{ old('payment_method')=='Transfer Bank'?'selected':'' }}>Transfer Bank</option>
                        <option value="COD" {{ old('payment_method')=='COD'?'selected':'' }}>COD (Cash on Delivery)</option>
                        <option value="QRIS" {{ old('payment_method')=='QRIS'?'selected':'' }}>QRIS</option>
                    </select>
            </section>
        </div>

        <aside class="lg:col-span-5 lg:sticky lg:top-32">
            <section class="glass-panel rounded-xl overflow-hidden">
                <div class="p-6 md:p-8 border-b border-on-surface/10">
                    <span class="vc-kicker block mb-2">Ringkasan</span>
                    <h2 class="font-display text-headline-md text-on-surface mb-0">Ringkasan Pesanan</h2>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    @foreach($carts as $cart)
                        <div class="flex items-start gap-4">
                            <img src="{{ $cart->product->image_url }}" alt="{{ $cart->product->name }}" class="w-16 h-20 object-cover bg-surface-container-low shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="text-on-surface leading-snug">{{ $cart->product->name }}</div>
                                <div class="text-on-surface-variant small">Qty {{ $cart->quantity }}</div>
                            </div>
                            <div class="text-primary text-end whitespace-nowrap">Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 md:p-8 border-t border-on-surface/10 bg-surface-container-low space-y-3">
                    <div class="flex justify-between gap-4 text-on-surface-variant">
                        <span>Subtotal ({{ $totalItems }} item)</span>
                        <span class="text-on-surface">Rp {{ number_format($promo['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @if($promo['quantity_discount'] > 0)
                        <div class="flex justify-between gap-4 text-success">
                            <span>Diskon Otomatis ({{ $promo['quantity_discount_percent'] }}%)</span>
                            <span>- Rp {{ number_format($promo['quantity_discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($promo['voucher_discount'] > 0)
                        <div class="flex justify-between gap-4 text-success">
                            <span>Voucher {{ $promo['voucher']->code }}</span>
                            <span>- Rp {{ number_format($promo['voucher_discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between gap-4 text-on-surface-variant">
                        <span>
                            Ongkir
                            <span class="block small" id="shippingDistance">Pilih provinsi tujuan</span>
                        </span>
                        <span class="text-on-surface" id="shippingCost">Rp 0</span>
                    </div>
                    <div class="flex justify-between gap-4 border-t border-on-surface/10 pt-4 mt-4">
                        <span class="text-on-surface">Total</span>
                        <strong class="font-display text-headline-md text-primary leading-none" id="grandTotal">Rp {{ number_format($promo['total'], 0, ',', '.') }}</strong>
                    </div>
                </div>

                <div class="p-6 md:p-8 border-t border-on-surface/10">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i>
                        Konfirmasi Pesanan
                    </button>
                    <p class="vc-body small text-center mt-3 mb-0">Pastikan alamat dan metode pembayaran sudah benar.</p>
                </div>
            </section>
        </aside>
    </div>
</form>

<form id="voucherForm" method="GET" action="{{ route('pembeli.checkout.show') }}"></form>

@php
    $areaOptions = [
        'Aceh' => [
            'Banda Aceh' => ['Baiturrahman', 'Kuta Alam', 'Syiah Kuala'],
            'Aceh Besar' => ['Darul Imarah', 'Ingin Jaya', 'Sukamakmur'],
            'Lhokseumawe' => ['Banda Sakti', 'Muara Dua', 'Blang Mangat'],
            'Aceh Tengah' => ['Bebesen', 'Kebayakan', 'Pegasing'],
        ],
        'Sumatera Utara' => [
            'Medan' => ['Medan Kota', 'Medan Baru', 'Medan Selayang'],
            'Deli Serdang' => ['Lubuk Pakam', 'Percut Sei Tuan', 'Tanjung Morawa'],
            'Binjai' => ['Binjai Kota', 'Binjai Timur', 'Binjai Utara'],
            'Pematangsiantar' => ['Siantar Barat', 'Siantar Timur', 'Siantar Utara'],
        ],
        'Sumatera Barat' => [
            'Padang' => ['Padang Barat', 'Koto Tangah', 'Lubuk Begalung'],
            'Bukittinggi' => ['Guguk Panjang', 'Mandiangin Koto Selayan', 'Aur Birugo Tigo Baleh'],
            'Payakumbuh' => ['Payakumbuh Barat', 'Payakumbuh Timur', 'Lamposi Tigo Nagori'],
            'Agam' => ['Lubuk Basung', 'Tilatang Kamang', 'Banuhampu'],
        ],
        'Riau' => [
            'Pekanbaru' => ['Sukajadi', 'Tampan', 'Marpoyan Damai'],
            'Dumai' => ['Dumai Kota', 'Dumai Timur', 'Bukit Kapur'],
            'Kampar' => ['Bangkinang Kota', 'Tambang', 'Siak Hulu'],
            'Siak' => ['Siak', 'Tualang', 'Minas'],
        ],
        'Kepulauan Riau' => [
            'Batam' => ['Batam Kota', 'Sekupang', 'Batu Aji'],
            'Tanjungpinang' => ['Tanjungpinang Kota', 'Bukit Bestari', 'Tanjungpinang Timur'],
            'Bintan' => ['Bintan Timur', 'Bintan Utara', 'Teluk Sebong'],
            'Karimun' => ['Karimun', 'Meral', 'Tebing'],
        ],
        'Jambi' => [
            'Jambi' => ['Jambi Selatan', 'Kota Baru', 'Telanaipura'],
            'Muaro Jambi' => ['Jambi Luar Kota', 'Sekernan', 'Mestong'],
            'Bungo' => ['Pasar Muara Bungo', 'Rimbo Tengah', 'Bathin III'],
            'Tanjung Jabung Barat' => ['Tungkal Ilir', 'Betara', 'Bram Itam'],
        ],
        'Bengkulu' => [
            'Bengkulu' => ['Ratu Samban', 'Gading Cempaka', 'Selebar'],
            'Rejang Lebong' => ['Curup', 'Curup Tengah', 'Curup Timur'],
            'Bengkulu Utara' => ['Arga Makmur', 'Padang Jaya', 'Lais'],
            'Mukomuko' => ['Kota Mukomuko', 'Ipuh', 'Penarik'],
        ],
        'Sumatera Selatan' => [
            'Palembang' => ['Ilir Barat I', 'Ilir Timur II', 'Sukarami'],
            'Prabumulih' => ['Prabumulih Timur', 'Prabumulih Barat', 'Cambai'],
            'Ogan Komering Ilir' => ['Kayu Agung', 'Tanjung Lubuk', 'Lempuing'],
            'Banyuasin' => ['Talang Kelapa', 'Banyuasin III', 'Betung'],
        ],
        'Kepulauan Bangka Belitung' => [
            'Pangkalpinang' => ['Rangkui', 'Bukit Intan', 'Gerunggang'],
            'Bangka' => ['Sungailiat', 'Belinyu', 'Pemali'],
            'Belitung' => ['Tanjung Pandan', 'Membalong', 'Sijuk'],
            'Bangka Tengah' => ['Koba', 'Pangkalan Baru', 'Simpang Katis'],
        ],
        'Lampung' => [
            'Bandar Lampung' => ['Tanjung Karang Pusat', 'Kedaton', 'Sukarame'],
            'Metro' => ['Metro Pusat', 'Metro Timur', 'Metro Barat'],
            'Lampung Selatan' => ['Kalianda', 'Natar', 'Jati Agung'],
            'Lampung Tengah' => ['Gunung Sugih', 'Terbanggi Besar', 'Seputih Banyak'],
        ],
        'Jawa Tengah' => [
            'Banyumas' => ['Purwokerto Barat', 'Purwokerto Timur', 'Purwokerto Utara', 'Purwokerto Selatan', 'Sokaraja'],
            'Purbalingga' => ['Purbalingga', 'Kalimanah', 'Bobotsari'],
            'Cilacap' => ['Cilacap Selatan', 'Cilacap Tengah', 'Majenang'],
            'Semarang' => ['Semarang Tengah', 'Semarang Barat', 'Tembalang'],
        ],
        'DI Yogyakarta' => [
            'Kota Yogyakarta' => ['Gondokusuman', 'Umbulharjo', 'Mergangsan'],
            'Sleman' => ['Depok', 'Mlati', 'Ngaglik'],
            'Bantul' => ['Bantul', 'Sewon', 'Kasihan'],
        ],
        'Jawa Barat' => [
            'Bandung' => ['Coblong', 'Sukajadi', 'Lengkong'],
            'Bekasi' => ['Bekasi Barat', 'Bekasi Timur', 'Jatiasih'],
            'Bogor' => ['Bogor Tengah', 'Bogor Utara', 'Tanah Sareal'],
        ],
        'DKI Jakarta' => [
            'Jakarta Pusat' => ['Menteng', 'Tanah Abang', 'Kemayoran'],
            'Jakarta Selatan' => ['Kebayoran Baru', 'Tebet', 'Pasar Minggu'],
            'Jakarta Barat' => ['Grogol Petamburan', 'Kebon Jeruk', 'Cengkareng'],
        ],
        'Banten' => [
            'Tangerang' => ['Tangerang', 'Ciledug', 'Karawaci'],
            'Tangerang Selatan' => ['Serpong', 'Pamulang', 'Ciputat'],
            'Serang' => ['Serang', 'Cipocok Jaya', 'Taktakan'],
        ],
        'Jawa Timur' => [
            'Surabaya' => ['Tegalsari', 'Wonokromo', 'Rungkut'],
            'Malang' => ['Klojen', 'Lowokwaru', 'Blimbing'],
            'Sidoarjo' => ['Sidoarjo', 'Taman', 'Waru'],
        ],
        'Bali' => [
            'Denpasar' => ['Denpasar Barat', 'Denpasar Timur', 'Denpasar Selatan'],
            'Badung' => ['Kuta', 'Mengwi', 'Abiansemal'],
            'Gianyar' => ['Ubud', 'Sukawati', 'Blahbatuh'],
        ],
        'Nusa Tenggara Barat' => [
            'Mataram' => ['Mataram', 'Cakranegara', 'Ampenan'],
            'Lombok Barat' => ['Gerung', 'Narmada', 'Lingsar'],
            'Lombok Tengah' => ['Praya', 'Pujut', 'Kopang'],
            'Sumbawa' => ['Sumbawa', 'Labuhan Badas', 'Moyo Hilir'],
        ],
        'Nusa Tenggara Timur' => [
            'Kupang' => ['Kota Lama', 'Oebobo', 'Maulafa'],
            'Ende' => ['Ende Tengah', 'Ende Selatan', 'Ende Timur'],
            'Sikka' => ['Alok', 'Alok Timur', 'Kewapante'],
            'Manggarai Barat' => ['Komodo', 'Lembor', 'Sano Nggoang'],
        ],
        'Kalimantan Barat' => [
            'Pontianak' => ['Pontianak Kota', 'Pontianak Barat', 'Pontianak Selatan'],
            'Kubu Raya' => ['Sungai Raya', 'Rasau Jaya', 'Sungai Kakap'],
            'Singkawang' => ['Singkawang Barat', 'Singkawang Tengah', 'Singkawang Utara'],
            'Ketapang' => ['Delta Pawan', 'Benua Kayong', 'Matan Hilir Selatan'],
        ],
        'Kalimantan Tengah' => [
            'Palangka Raya' => ['Pahandut', 'Jekan Raya', 'Sebangau'],
            'Kotawaringin Timur' => ['Mentawa Baru Ketapang', 'Baamang', 'Cempaga'],
            'Kotawaringin Barat' => ['Arut Selatan', 'Kumai', 'Pangkalan Banteng'],
            'Kapuas' => ['Selat', 'Basarang', 'Kapuas Hilir'],
        ],
        'Kalimantan Selatan' => [
            'Banjarmasin' => ['Banjarmasin Tengah', 'Banjarmasin Barat', 'Banjarmasin Timur'],
            'Banjarbaru' => ['Landasan Ulin', 'Cempaka', 'Banjarbaru Utara'],
            'Banjar' => ['Martapura', 'Kertak Hanyar', 'Gambut'],
            'Tanah Laut' => ['Pelaihari', 'Bati-Bati', 'Takisung'],
        ],
        'Kalimantan Timur' => [
            'Samarinda' => ['Samarinda Kota', 'Samarinda Ulu', 'Sungai Kunjang'],
            'Balikpapan' => ['Balikpapan Kota', 'Balikpapan Selatan', 'Balikpapan Utara'],
            'Kutai Kartanegara' => ['Tenggarong', 'Loa Janan', 'Muara Badak'],
            'Bontang' => ['Bontang Utara', 'Bontang Selatan', 'Bontang Barat'],
        ],
        'Kalimantan Utara' => [
            'Tarakan' => ['Tarakan Barat', 'Tarakan Tengah', 'Tarakan Timur'],
            'Bulungan' => ['Tanjung Selor', 'Tanjung Palas', 'Sekatak'],
            'Nunukan' => ['Nunukan', 'Nunukan Selatan', 'Sebatik'],
            'Malinau' => ['Malinau Kota', 'Malinau Utara', 'Malinau Barat'],
        ],
        'Sulawesi Utara' => [
            'Manado' => ['Wenang', 'Malalayang', 'Mapanget'],
            'Bitung' => ['Maesa', 'Aertembaga', 'Matuari'],
            'Minahasa' => ['Tondano Barat', 'Tondano Timur', 'Pineleng'],
            'Tomohon' => ['Tomohon Tengah', 'Tomohon Selatan', 'Tomohon Utara'],
        ],
        'Gorontalo' => [
            'Gorontalo' => ['Kota Selatan', 'Kota Tengah', 'Dungingi'],
            'Gorontalo Utara' => ['Kwandang', 'Anggrek', 'Tolinggula'],
            'Bone Bolango' => ['Kabila', 'Suwawa', 'Tilongkabila'],
            'Boalemo' => ['Tilamuta', 'Dulupi', 'Paguyaman'],
        ],
        'Sulawesi Tengah' => [
            'Palu' => ['Palu Barat', 'Palu Selatan', 'Mantikulore'],
            'Donggala' => ['Banawa', 'Labuan', 'Sindue'],
            'Poso' => ['Poso Kota', 'Lage', 'Pamona Puselemba'],
            'Morowali' => ['Bungku Tengah', 'Bahodopi', 'Bumi Raya'],
        ],
        'Sulawesi Barat' => [
            'Mamuju' => ['Mamuju', 'Simboro', 'Kalukku'],
            'Majene' => ['Banggae', 'Banggae Timur', 'Pamboang'],
            'Polewali Mandar' => ['Polewali', 'Wonomulyo', 'Campalagian'],
            'Mamasa' => ['Mamasa', 'Sumarorong', 'Tanduk Kalua'],
        ],
        'Sulawesi Selatan' => [
            'Makassar' => ['Ujung Pandang', 'Panakkukang', 'Tamalanrea'],
            'Gowa' => ['Somba Opu', 'Pallangga', 'Bontomarannu'],
            'Maros' => ['Turikale', 'Mandai', 'Bantimurung'],
            'Parepare' => ['Bacukiki', 'Ujung', 'Soreang'],
        ],
        'Sulawesi Tenggara' => [
            'Kendari' => ['Kendari Barat', 'Mandonga', 'Baruga'],
            'Baubau' => ['Betoambari', 'Wolio', 'Murhum'],
            'Kolaka' => ['Kolaka', 'Wundulako', 'Pomalaa'],
            'Konawe' => ['Unaaha', 'Wawotobi', 'Pondidaha'],
        ],
        'Maluku' => [
            'Ambon' => ['Sirimau', 'Nusaniwe', 'Teluk Ambon'],
            'Maluku Tengah' => ['Amahai', 'Kota Masohi', 'Teon Nila Serua'],
            'Tual' => ['Pulau Dullah Selatan', 'Pulau Dullah Utara', 'Tayando Tam'],
            'Seram Bagian Barat' => ['Kairatu', 'Piru', 'Taniwel'],
        ],
        'Maluku Utara' => [
            'Ternate' => ['Ternate Tengah', 'Ternate Selatan', 'Ternate Utara'],
            'Tidore Kepulauan' => ['Tidore', 'Tidore Timur', 'Oba Utara'],
            'Halmahera Barat' => ['Jailolo', 'Sahu', 'Ibu'],
            'Halmahera Selatan' => ['Bacan', 'Bacan Timur', 'Gane Barat'],
        ],
        'Papua Barat Daya' => [
            'Sorong' => ['Sorong Barat', 'Sorong Timur', 'Sorong Utara'],
            'Kabupaten Sorong' => ['Aimas', 'Mayamuk', 'Salawati'],
            'Raja Ampat' => ['Waigeo Selatan', 'Waigeo Barat', 'Misool'],
            'Maybrat' => ['Aifat', 'Aitinyo', 'Ayamaru'],
        ],
        'Papua Barat' => [
            'Manokwari' => ['Manokwari Barat', 'Manokwari Timur', 'Manokwari Selatan'],
            'Fakfak' => ['Fakfak', 'Fakfak Tengah', 'Pariwari'],
            'Kaimana' => ['Kaimana', 'Buruway', 'Teluk Arguni'],
            'Teluk Bintuni' => ['Bintuni', 'Manimeri', 'Tembuni'],
        ],
        'Papua Tengah' => [
            'Nabire' => ['Nabire', 'Nabire Barat', 'Teluk Kimi'],
            'Mimika' => ['Mimika Baru', 'Wania', 'Kuala Kencana'],
            'Paniai' => ['Paniai Timur', 'Bibida', 'Aradide'],
            'Dogiyai' => ['Kamu', 'Kamu Selatan', 'Mapia'],
        ],
        'Papua Pegunungan' => [
            'Jayawijaya' => ['Wamena', 'Hubikosi', 'Asolokobal'],
            'Yahukimo' => ['Dekai', 'Obio', 'Suru-Suru'],
            'Lanny Jaya' => ['Tiom', 'Makki', 'Pirime'],
            'Tolikara' => ['Karubaga', 'Kanggime', 'Bokondini'],
        ],
        'Papua Selatan' => [
            'Merauke' => ['Merauke', 'Semangga', 'Tanah Miring'],
            'Boven Digoel' => ['Mandobo', 'Jair', 'Mindiptana'],
            'Mappi' => ['Obaa', 'Assue', 'Haju'],
            'Asmat' => ['Agats', 'Atsy', 'Sawa Erma'],
        ],
        'Papua' => [
            'Jayapura' => ['Jayapura Utara', 'Jayapura Selatan', 'Abepura'],
            'Kabupaten Jayapura' => ['Sentani', 'Sentani Timur', 'Waibu'],
            'Keerom' => ['Arso', 'Skanto', 'Waris'],
            'Sarmi' => ['Sarmi', 'Pantai Timur', 'Bonggo'],
        ],
    ];

    foreach($shippingProvinces as $province => $shipping) {
        $areaOptions[$province] ??= [
            'Kota Utama' => ['Kecamatan Pusat', 'Kecamatan Barat', 'Kecamatan Timur'],
            'Kabupaten Utama' => ['Kecamatan Utara', 'Kecamatan Selatan', 'Kecamatan Kota'],
        ];
    }
@endphp

<script>
document.addEventListener('DOMContentLoaded', () => {
    const areas = @json($areaOptions);
    const baseTotal = {{ (int) $promo['total'] }};
    const province = document.getElementById('shippingProvince');
    const city = document.getElementById('shippingCity');
    const district = document.getElementById('shippingDistrict');
    const shippingCost = document.getElementById('shippingCost');
    const shippingDistance = document.getElementById('shippingDistance');
    const grandTotal = document.getElementById('grandTotal');

    const formatRupiah = (value) => new Intl.NumberFormat('id-ID').format(value);
    const fillSelect = (select, values, selected, placeholder) => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        values.forEach((value) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            option.selected = value === selected;
            select.appendChild(option);
        });
    };

    const refreshCities = () => {
        const selectedProvince = province.value;
        const selectedCity = city.dataset.old || '';
        const cities = selectedProvince && areas[selectedProvince] ? Object.keys(areas[selectedProvince]) : [];
        fillSelect(city, cities, selectedCity, '-- Pilih kab/kota --');
        city.dataset.old = '';
        refreshDistricts();
        refreshShipping();
    };

    const refreshDistricts = () => {
        const selectedProvince = province.value;
        const selectedCity = city.value;
        const selectedDistrict = district.dataset.old || '';
        const districts = selectedProvince && selectedCity && areas[selectedProvince]?.[selectedCity]
            ? areas[selectedProvince][selectedCity]
            : [];
        fillSelect(district, districts, selectedDistrict, '-- Pilih kecamatan --');
        district.dataset.old = '';
    };

    const refreshShipping = () => {
        const option = province.selectedOptions[0];
        const cost = Number(option?.dataset.cost || 0);
        const distance = Number(option?.dataset.distance || 0);
        shippingCost.textContent = `Rp ${formatRupiah(cost)}`;
        shippingDistance.textContent = distance > 0
            ? `Jarak dari Purwokerto: ${formatRupiah(distance)} km`
            : 'Pilih provinsi tujuan';
        grandTotal.textContent = `Rp ${formatRupiah(baseTotal + cost)}`;
    };

    province.addEventListener('change', refreshCities);
    city.addEventListener('change', refreshDistricts);
    refreshCities();
    setTimeout(refreshCities, 0);
    window.addEventListener('pageshow', refreshCities);
});
</script>

@endsection
