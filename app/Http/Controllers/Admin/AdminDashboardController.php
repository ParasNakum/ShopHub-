<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(6)->get();
        $recentUsers = User::latest()->take(5)->get();
        $topProducts = Product::with('category')->orderBy('stock', 'asc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers', 'topProducts'));
    }
}
