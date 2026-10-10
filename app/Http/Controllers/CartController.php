<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getCartQuery()
    {
        if (Auth::check()) {
            return CartItem::with('product')->where('user_id', Auth::id());
        }
        $sessionId = session()->getId();
        return CartItem::with('product')->where('session_id', $sessionId);
    }

    public function index()
    {
        $cartItems = $this->getCartQuery()->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });

        $shipping = $subtotal > 0 ? ($subtotal >= 999 ? 0 : 99.00) : 0;
        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $shipping + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, this product is currently out of stock.');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $newQty = min($cartItem->quantity + $quantity, $product->stock);
                $cartItem->update(['quantity' => $newQty]);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => min($quantity, $product->stock),
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $newQty = min($cartItem->quantity + $quantity, $product->stock);
                $cartItem->update(['quantity' => $newQty]);
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId,
                    'quantity' => min($quantity, $product->stock),
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to cart!",
                'cart_count' => $this->getCartQuery()->sum('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('success', "{$product->name} has been added to your cart!");
    }

    public function update(Request $request, $id)
    {
        $cartItem = $this->getCartQuery()->where('id', $id)->firstOrFail();
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }

        if ($cartItem->product && $quantity > $cartItem->product->stock) {
            return back()->with('error', "Only {$cartItem->product->stock} units available in stock.");
        }

        $cartItem->update(['quantity' => $quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cartItem = $this->getCartQuery()->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
    }

    public function clear()
    {
        $this->getCartQuery()->delete();
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
