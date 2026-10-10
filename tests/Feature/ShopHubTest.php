<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ShopHubTest extends TestCase
{
    public function test_storefront_home_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ShopHub');
    }

    public function test_catalog_search_and_filters(): void
    {
        $response = $this->get('/products?q=Headphones');
        $response->assertStatus(200);
        $response->assertSee('AcousticPro');
    }

    public function test_product_detail_page(): void
    {
        $response = $this->get('/products/acousticpro-wireless-noise-cancelling-headphones');
        $response->assertStatus(200);
        $response->assertSee('AcousticPro Wireless Noise-Cancelling Headphones');
    }

    public function test_cart_page_is_accessible(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_access_for_admin(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('System Administration Overview');
    }

    public function test_seller_dashboard_access_for_seller(): void
    {
        $seller = User::where('role', 'seller')->first();
        $response = $this->actingAs($seller)->get('/seller/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Seller Dashboard Overview');
    }

    public function test_customer_order_history_access(): void
    {
        $customer = User::where('role', 'customer')->first();
        $response = $this->actingAs($customer)->get('/orders');
        $response->assertStatus(200);
    }

    public function test_customer_can_add_item_to_cart(): void
    {
        $customer = User::where('role', 'customer')->first();
        $product = \App\Models\Product::where('status', 'active')->first();

        $response = $this->actingAs($customer)->post("/cart/add/{$product->id}", [
            'quantity' => 2,
        ]);

        $response->assertRedirect('/cart');
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_customer_can_place_order(): void
    {
        $customer = User::where('role', 'customer')->first();
        $product = \App\Models\Product::where('status', 'active')->first();

        \App\Models\CartItem::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($customer)->post('/checkout', [
            'shipping_name' => 'Paras Tester',
            'shipping_email' => 'paras.tester@example.com',
            'shipping_phone' => '+91 99999 88888',
            'shipping_address' => 'Sample Street 123',
            'shipping_city' => 'Ahmedabad',
            'shipping_postal_code' => '380015',
            'payment_method' => 'cod',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'shipping_email' => 'paras.tester@example.com',
            'payment_method' => 'cod',
        ]);
    }

    public function test_user_can_register_as_seller(): void
    {
        $email = 'new_seller_' . uniqid() . '@example.com';
        $response = $this->post('/register', [
            'name' => 'Brand New Seller',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'seller',
        ]);

        $response->assertRedirect('/seller/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'seller',
        ]);
    }
}
