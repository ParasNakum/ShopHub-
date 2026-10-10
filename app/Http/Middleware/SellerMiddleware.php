<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access the seller portal.');
        }

        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Access denied. Seller account required.');
        }

        return $next($request);
    }
}
