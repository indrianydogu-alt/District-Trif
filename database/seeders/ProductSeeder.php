<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Elektronik', 'Smartphone Android Pro', 'Smartphone dengan kamera 64MP dan baterai 5000mAh.'],
            ['Elektronik', 'Laptop Ultrabook 14"', 'Laptop ringan dengan prosesor terbaru dan SSD 512GB.'],
            ['Elektronik', 'Headphone Wireless', 'Headphone bluetooth dengan noise cancelling.'],
            ['Elektronik', 'Smartwatch Sport', 'Jam tangan pintar untuk olahraga dan kesehatan.'],
            ['Pakaian', 'Kaos Polos Premium', 'Kaos katun premium 100% nyaman dipakai.'],
            ['Pakaian', 'Kemeja Flanel', 'Kemeja flanel motif kotak warna klasik.'],
            ['Pakaian', 'Jaket Bomber', 'Jaket bomber bahan parasut waterproof.'],
            ['Pakaian', 'Celana Jeans Slim Fit', 'Celana jeans slim fit warna biru klasik.'],
            ['Makanan', 'Kopi Arabika 250gr', 'Kopi arabika single origin asli petani lokal.'],
            ['Makanan', 'Cokelat Artisan', 'Cokelat artisan dark 70% cocoa.'],
            ['Makanan', 'Madu Hutan Murni', 'Madu hutan murni 500ml tanpa pengawet.'],
            ['Makanan', 'Teh Hijau Premium', 'Teh hijau pilihan dengan aroma harum.'],
            ['Olahraga', 'Sepatu Lari Pro', 'Sepatu lari dengan teknologi cushioning terbaru.'],
            ['Olahraga', 'Matras Yoga Anti-slip', 'Matras yoga tebal 6mm anti-slip.'],
            ['Olahraga', 'Dumbbell 5kg', 'Dumbbell pasangan untuk latihan di rumah.'],
            ['Olahraga', 'Tas Gym Waterproof', 'Tas gym dengan kompartemen sepatu terpisah.'],
            ['Rumah Tangga', 'Set Pisau Dapur', 'Set pisau dapur stainless steel lengkap.'],
            ['Rumah Tangga', 'Panci Anti Lengket', 'Panci anti lengket ukuran 24cm.'],
            ['Rumah Tangga', 'Tempat Tidur Lipat', 'Tempat tidur lipat portable untuk tamu.'],
            ['Rumah Tangga', 'Lampu LED Hias', 'Lampu LED hias hemat energi multi warna.'],
        ];

        foreach ($products as $i => [$catName, $name, $desc]) {
            $category = Category::where('name', $catName)->first();
            if (!$category) continue;
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'description' => $desc,
                    'price' => random_int(10000, 500000),
                    'stock' => random_int(10, 100),
                    'is_active' => true,
                ]
            );
        }
    }
}
