<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        $orderItems = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->paginate(12);

        return view('seller.orders.index', compact('orderItems'));
    }

    public function show($id)
    {
        $sellerId = Auth::id();

        $order = Order::with(['items' => function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId)->with('product');
        }, 'user'])->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }
}
