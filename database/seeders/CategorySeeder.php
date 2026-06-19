<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Produk elektronik dan gadget terkini.'],
            ['name' => 'Pakaian', 'description' => 'Fashion pria dan wanita.'],
            ['name' => 'Makanan', 'description' => 'Aneka makanan dan minuman.'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga.'],
            ['name' => 'Rumah Tangga', 'description' => 'Kebutuhan rumah tangga sehari-hari.'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'description' => $cat['description']]
            );
        }
    }
}
