<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->default(0)->after('order_code');
            $table->decimal('quantity_discount', 15, 2)->default(0)->after('subtotal');
            $table->string('voucher_code')->nullable()->after('quantity_discount');
            $table->decimal('voucher_discount', 15, 2)->default(0)->after('voucher_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'quantity_discount', 'voucher_code', 'voucher_discount']);
        });
    }
};
