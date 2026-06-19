<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_province')->nullable()->after('shipping_address');
            $table->string('shipping_city')->nullable()->after('shipping_province');
            $table->string('shipping_district')->nullable()->after('shipping_city');
            $table->text('shipping_detail')->nullable()->after('shipping_district');
            $table->unsignedInteger('shipping_distance_km')->default(0)->after('shipping_detail');
            $table->decimal('shipping_cost', 15, 2)->default(0)->after('shipping_distance_km');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_province',
                'shipping_city',
                'shipping_district',
                'shipping_detail',
                'shipping_distance_km',
                'shipping_cost',
            ]);
        });
    }
};
