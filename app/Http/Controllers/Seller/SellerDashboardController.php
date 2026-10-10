<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        $totalProducts = Product::where('seller_id', $sellerId)->count();
        $activeProducts = Product::where('seller_id', $sellerId)->where('status', 'active')->count();
        $outOfStockProducts = Product::where('seller_id', $sellerId)->where('stock', '<=', 0)->count();

        $sellerOrderItems = OrderItem::where('seller_id', $sellerId);
        $totalItemsSold = (clone $sellerOrderItems)->sum('quantity');
        $totalRevenue = (clone $sellerOrderItems)->sum('subtotal');

        $recentOrderItems = OrderItem::with(['order', 'product'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->take(6)
            ->get();

        $recentProducts = Product::where('seller_id', $sellerId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'outOfStockProducts',
            'totalItemsSold',
            'totalRevenue',
            'recentOrderItems',
            'recentProducts'
        ));
    }
}
