<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'sales' => Order::query()->where('status', '!=', 'cancelled')->sum('total'),
                'orders' => Order::query()->count(),
                'products' => Product::query()->count(),
                'customers' => User::query()->count(),
            ],
            'recentOrders' => Order::query()->latest()->take(5)->get(),
            'lowStockProducts' => Product::query()->where('stock', '<=', 8)->orderBy('stock')->take(5)->get(),
            'salesByMonth' => Order::query()
                ->selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(total) as revenue")
                ->where('status', '!=', 'cancelled')
                ->groupBy('month')
                ->orderByRaw('MIN(created_at)')
                ->take(6)
                ->get(),
            'statusBreakdown' => Order::query()
                ->select('status', DB::raw('count(*) as aggregate'))
                ->groupBy('status')
                ->pluck('aggregate', 'status'),
        ]);
    }
}
