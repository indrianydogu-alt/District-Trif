<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('shipment_history')) {
            Schema::create('shipment_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->string('status');
                $table->text('description');
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();

                $table->index(['order_id', 'created_at']);
            });
        }

        if (Schema::hasTable('shipments') && ! Schema::hasColumn('shipments', 'received_at')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->timestamp('received_at')->nullable()->after('delivered_at');
            });
        }

        if (Schema::hasTable('orders') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled') NOT NULL DEFAULT 'pending_payment'");
            DB::statement("UPDATE orders SET status = 'pending_payment' WHERE status = 'pending'");
            DB::statement("UPDATE orders SET status = 'completed' WHERE status = 'delivered'");
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending_payment', 'paid', 'processing', 'shipped', 'completed', 'cancelled') NOT NULL DEFAULT 'pending_payment'");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'");
            DB::statement("UPDATE orders SET status = 'pending' WHERE status = 'pending_payment'");
            DB::statement("UPDATE orders SET status = 'delivered' WHERE status = 'completed'");
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending'");
        }

        if (Schema::hasTable('shipments') && Schema::hasColumn('shipments', 'received_at')) {
            Schema::table('shipments', function (Blueprint $table) {
                $table->dropColumn('received_at');
            });
        }

        Schema::dropIfExists('shipment_history');
    }
};
