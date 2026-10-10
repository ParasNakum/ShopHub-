<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();

        $featuredProducts = Product::with(['category', 'seller'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::with(['category', 'seller'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $stats = [
            'total_products' => Product::where('status', 'active')->count(),
            'total_categories' => $categories->count(),
        ];

        return view('home', compact('categories', 'featuredProducts', 'latestProducts', 'stats'));
    }
}
