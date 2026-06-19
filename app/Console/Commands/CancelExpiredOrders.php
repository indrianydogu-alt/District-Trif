<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Auto-cancel order >24 jam yang belum bayar dan belum upload bukti. Stok dikembalikan.';

    public function handle(): int
    {
        $cutoff = now()->subHours(24);

        $orders = Order::with('items')
            ->where('status', '!=', 'cancelled')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '<', $cutoff)
            ->whereDoesntHave('payment', function ($q) {
                $q->whereNotNull('proof_image');
            })
            ->get();

        if ($orders->isEmpty()) {
            $this->info('Tidak ada order yang perlu dibatalkan.');
            return self::SUCCESS;
        }

        $count = 0;
        foreach ($orders as $order) {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'rejected',
                ]);
            });
            $count++;
            $this->line("Cancelled: {$order->order_code}");
        }

        $this->info("{$count} order dibatalkan otomatis.");
        return self::SUCCESS;
    }
}
