<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to proceed with checkout.');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty. Add items before checking out.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });

        $shipping = $subtotal >= 999 ? 0 : 99.00;
        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $shipping + $tax;

        $user = Auth::user();

        return view('orders.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'user'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,card,upi',
            'order_notes' => 'nullable|string|max:500',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if (!$item->product || $item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', "Sorry, '{$item->product->name}' does not have enough stock available.");
            }
        }

        $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $shipping = $subtotal >= 999 ? 0 : 99.00;
        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $shipping + $tax;

        $order = DB::transaction(function () use ($validated, $cartItems, $subtotal, $shipping, $tax, $total) {
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_fee' => $shipping,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'paid',
                'payment_method' => $validated['payment_method'],
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'seller_id' => $cartItem->product->seller_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Deduct stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear user's cart
            CartItem::where('user_id', Auth::id())->delete();

            return $order;
        });

        return redirect()->route('orders.success', $order->id)->with('success', 'Your order has been placed successfully!');
    }

    public function success($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::with('items')->where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            // Restock items
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', "Order #{$order->order_number} has been cancelled.");
    }
}
