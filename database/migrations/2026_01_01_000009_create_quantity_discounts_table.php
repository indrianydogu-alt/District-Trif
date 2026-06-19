<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quantity_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_items');
            $table->unsignedTinyInteger('discount_percent');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('quantity_discounts')->insert([
            ['min_items' => 2, 'discount_percent' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['min_items' => 3, 'discount_percent' => 15, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('quantity_discounts');
    }
};
