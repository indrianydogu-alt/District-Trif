<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'pembeli')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        $salesByDay = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::now()->subDays($i)->format('d M');
            $row = $salesByDay->firstWhere('date', $date);
            $chartData[] = $row ? (float) $row->total : 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalUsers', 'totalRevenue',
            'todayOrders', 'recentOrders', 'chartLabels', 'chartData'
        ));
    }
}
