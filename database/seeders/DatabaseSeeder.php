<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@shophub.com'],
            [
                'name' => 'ShopHub Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+91 98765 00001',
                'address' => 'Admin HQ, Tech Park, Ahmedabad',
                'status' => 'active',
            ]
        );

        $techSeller = User::firstOrCreate(
            ['email' => 'techseller@shophub.com'],
            [
                'name' => 'Apex Tech Solutions',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'phone' => '+91 98765 00002',
                'address' => 'Shop 42, Digital Plaza, Bangalore',
                'status' => 'active',
            ]
        );

        $fashionSeller = User::firstOrCreate(
            ['email' => 'fashionseller@shophub.com'],
            [
                'name' => 'Urban Vogue Studio',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'phone' => '+91 98765 00003',
                'address' => 'Unit 12, Fashion Avenue, Mumbai',
                'status' => 'active',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@shophub.com'],
            [
                'name' => 'Sarah Jenkins',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+91 98765 11111',
                'address' => 'Flat 302, Green Valley Apartments, Pune',
                'status' => 'active',
            ]
        );

        $parasCustomer = User::firstOrCreate(
            ['email' => 'paras@example.com'],
            [
                'name' => 'Paras Nakum',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+91 98765 22222',
                'address' => '104, Sunrise Residency, Ahmedabad',
                'status' => 'active',
            ]
        );

        // 2. Create Categories
        $categoriesData = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Smart gadgets, computers, tablets and smart home devices',
                'icon' => 'bi-laptop',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Audio & Sound',
                'slug' => 'audio-sound',
                'description' => 'Noise-cancelling headphones, wireless earbuds, and speakers',
                'icon' => 'bi-headphones',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Smartwatches',
                'slug' => 'smartwatches',
                'description' => 'Fitness trackers, luxury smartwatches, and smart bands',
                'icon' => 'bi-smartwatch',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Fashion & Apparel',
                'slug' => 'fashion-apparel',
                'description' => 'Trending contemporary fashion, shoes, apparel, and eyewear',
                'icon' => 'bi-bag-check',
                'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Modern kitchenware, ergonomic decor, and cozy essentials',
                'icon' => 'bi-house-heart',
                'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Mirrorless cameras, premium lenses, and vlogging kits',
                'icon' => 'bi-camera',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $categories[$catData['slug']] = Category::firstOrCreate(['slug' => $catData['slug']], $catData);
        }

        // 3. Create Diverse Products
        $productsData = [
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['audio-sound']->id,
                'name' => 'AcousticPro Wireless Noise-Cancelling Headphones',
                'slug' => 'acousticpro-wireless-noise-cancelling-headphones',
                'sku' => 'AP-NC-001',
                'short_description' => 'Flagship active noise cancellation with 40-hour battery life and spatial audio support.',
                'description' => "Experience immersive sound with custom 40mm titanium drivers. Engineered for pure acoustic clarity, the AcousticPro delivers up to 40 hours of playtime on a single charge with ultra-low latency Bluetooth 5.3 connectivity. Includes plush memory foam earcups, multi-device pairing, and customizable EQ presets via our companion mobile app.",
                'price' => 179.99,
                'compare_price' => 249.99,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['smartwatches']->id,
                'name' => 'Titanium Elite Smartwatch Series 7',
                'slug' => 'titanium-elite-smartwatch-series-7',
                'sku' => 'TITAN-SW-7',
                'short_description' => 'Precision AMOLED display with real-time biometric health monitoring and 5ATM water resistance.',
                'description' => "Precision craftsmanship meets cutting-edge health tracking. Features an ultra-bright always-on AMOLED display encased in Grade 5 Titanium. Track ECG, SpO2, sleep architecture, and over 120 sports activities with built-in multi-band GPS.",
                'price' => 299.00,
                'compare_price' => 349.00,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['electronics']->id,
                'name' => 'Apex Ultralight 14" OLED Laptop',
                'slug' => 'apex-ultralight-14-oled-laptop',
                'sku' => 'APX-LAP-14',
                'short_description' => 'Latest generation octa-core processor, 32GB RAM, 1TB NVMe SSD in a sleek 1.1kg chassis.',
                'description' => "Engineered for creators and professionals on the move. Boasting a vivid 2.8K 120Hz OLED display with 100% DCI-P3 color gamut, back-lit tactile keyboard, Thunderbolt 4 ports, and all-day 16-hour battery life.",
                'price' => 1099.00,
                'compare_price' => 1299.00,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $fashionSeller->id,
                'category_id' => $categories['fashion-apparel']->id,
                'name' => 'Minimalist Heritage Leather Weekend Bag',
                'slug' => 'minimalist-heritage-leather-weekend-bag',
                'sku' => 'VOG-BAG-01',
                'short_description' => 'Handcrafted full-grain Italian leather duffel with dedicated footwear compartment.',
                'description' => "Travel in effortless elegance. Handcrafted from vegetable-tanned full-grain leather that develops a gorgeous patina over time. Features solid brass hardware, water-resistant twill lining, and a separate shoe compartment.",
                'price' => 189.50,
                'compare_price' => 220.00,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1547949003-9792a18a2601?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['photography']->id,
                'name' => 'Lumix Compact 4K Mirrorless Camera',
                'slug' => 'lumix-compact-4k-mirrorless-camera',
                'sku' => 'CAM-4K-09',
                'short_description' => '24.2 MP APS-C sensor with 5-axis in-body image stabilization and crisp 4K 60fps video.',
                'description' => "Capture cinematic moments in razor-sharp resolution. Featuring hybrid phase-detection autofocus with eye-tracking for humans and animals, flip-out touchscreen, and dual card slots.",
                'price' => 749.00,
                'compare_price' => 849.00,
                'stock' => 9,
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'seller_id' => $fashionSeller->id,
                'category_id' => $categories['fashion-apparel']->id,
                'name' => 'Retro Classic Aviator Polarized Sunglasses',
                'slug' => 'retro-classic-aviator-polarized-sunglasses',
                'sku' => 'VOG-SUN-44',
                'short_description' => 'UV400 protection with lightweight titanium alloy frame and scratch-resistant lenses.',
                'description' => "Iconic timeless styling engineered with modern optics. Polarized TAC lenses eliminate glare while maintaining true color perception. Comes with leather protective case and microfiber cleaning cloth.",
                'price' => 59.99,
                'compare_price' => 89.99,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'seller_id' => $fashionSeller->id,
                'category_id' => $categories['home-living']->id,
                'name' => 'Artisan Ceramic Pour-Over Coffee Dripper Set',
                'slug' => 'artisan-ceramic-pour-over-coffee-dripper-set',
                'sku' => 'HM-COF-88',
                'short_description' => 'Matte-finish ceramic brewer with borosilicate glass decanter and 40 unbleached filters.',
                'description' => "Brew cafe-quality pour-over coffee right at home. The spiral rib interior promotes optimum water flow rate and extraction. The 600ml heat-resistant decanter features an ergonomic handle and drip-free spout.",
                'price' => 45.00,
                'compare_price' => 55.00,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['audio-sound']->id,
                'name' => 'BassWave Rugged Waterproof Bluetooth Speaker',
                'slug' => 'basswave-rugged-waterproof-bluetooth-speaker',
                'sku' => 'SPK-IPX7-2',
                'short_description' => 'IP67 waterproof rating with 360-degree room-filling acoustic bass and 24-hour battery.',
                'description' => "Built for adventures from the backyard pool to mountain trails. Featuring dual neodymium drivers and dual passive radiators for deep bass without distortion. Supports stereo pairing with another speaker.",
                'price' => 89.99,
                'compare_price' => 119.99,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $fashionSeller->id,
                'category_id' => $categories['fashion-apparel']->id,
                'name' => 'Urban Aero Breathable Running Sneakers',
                'slug' => 'urban-aero-breathable-running-sneakers',
                'sku' => 'SNK-AERO-09',
                'short_description' => 'Engineered knit upper with responsive foam cushioning and high-grip rubber outsole.',
                'description' => "Lightweight comfort tailored for urban commuting and road running. Features a seamless knit upper for breathability, cushioned midsole for impact absorption, and reinforced heel counter for stability.",
                'price' => 95.00,
                'compare_price' => 125.00,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['electronics']->id,
                'name' => 'Nova Glow RGB Mechanical Gaming Keyboard',
                'slug' => 'nova-glow-rgb-mechanical-gaming-keyboard',
                'sku' => 'KB-RGB-MK',
                'short_description' => 'Hot-swappable linear switches with per-key RGB backlighting and aircraft aluminum top frame.',
                'description' => "Level up your typing and gaming experience with factory-lubricated mechanical switches. PBT doubleshot keycaps prevent shine, while the multi-function media roller allows instant volume and brightness adjustment.",
                'price' => 119.00,
                'compare_price' => 149.00,
                'stock' => 16,
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'seller_id' => $fashionSeller->id,
                'category_id' => $categories['home-living']->id,
                'name' => 'Minimalist Ergonomic Wood Desk Lamp',
                'slug' => 'minimalist-ergonomic-wood-desk-lamp',
                'sku' => 'LMP-WOOD-01',
                'short_description' => 'Solid oak construction with dimmable flicker-free LED and wireless phone charging pad base.',
                'description' => "Warm natural aesthetics blend with modern desk functionality. Touch control enables 5 color temperatures and stepless brightness dimming. Built-in 15W Qi wireless charger at the base.",
                'price' => 64.99,
                'compare_price' => 84.99,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'seller_id' => $techSeller->id,
                'category_id' => $categories['electronics']->id,
                'name' => 'PowerVolt 65W GaN Fast Charger Trio',
                'slug' => 'powervolt-65w-gan-fast-charger-trio',
                'sku' => 'CHG-GAN-65',
                'short_description' => 'Dual USB-C and single USB-A ports powered by Gallium Nitride technology in a compact plug.',
                'description' => "Charge your laptop, smartphone, and tablet simultaneously at maximum speed. Intelligent power distribution protects against overheating and overvoltage.",
                'price' => 38.00,
                'compare_price' => 49.00,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&auto=format&fit=crop&q=80',
                'status' => 'active',
                'is_featured' => false,
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $prodData) {
            $createdProducts[] = Product::firstOrCreate(['slug' => $prodData['slug']], $prodData);
        }

        // 4. Create Sample Customer Reviews
        $reviewsData = [
            [
                'product_id' => $createdProducts[0]->id,
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => "Best noise cancelling headphones I have used! Sound stage is very clear and the battery easily lasts an entire work week.",
            ],
            [
                'product_id' => $createdProducts[0]->id,
                'user_id' => $parasCustomer->id,
                'rating' => 5,
                'comment' => "Remarkable build quality. Pairs smoothly with both my laptop and phone without stuttering.",
            ],
            [
                'product_id' => $createdProducts[1]->id,
                'user_id' => $customer->id,
                'rating' => 4,
                'comment' => "Superb screen readability outdoors in bright sunlight. Accurate step and sleep tracking.",
            ],
            [
                'product_id' => $createdProducts[3]->id,
                'user_id' => $parasCustomer->id,
                'rating' => 5,
                'comment' => "The leather feels premium and smells genuine. Perfect capacity for weekend getaways.",
            ],
        ];

        foreach ($reviewsData as $rev) {
            Review::firstOrCreate(
                ['product_id' => $rev['product_id'], 'user_id' => $rev['user_id']],
                $rev
            );
        }

        // 5. Create Sample Orders for Demo Statistics
        $sampleOrder = Order::firstOrCreate(
            ['order_number' => 'ORD-SHOPHUB001'],
            [
                'user_id' => $parasCustomer->id,
                'subtotal' => 269.98,
                'tax' => 13.50,
                'shipping_fee' => 0.00,
                'total_amount' => 283.48,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'card',
                'shipping_name' => 'Paras Nakum',
                'shipping_email' => 'paras@example.com',
                'shipping_phone' => '+91 98765 22222',
                'shipping_address' => '104, Sunrise Residency, SG Highway',
                'shipping_city' => 'Ahmedabad',
                'shipping_postal_code' => '380054',
                'order_notes' => 'Please leave with reception if unavailable.',
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $sampleOrder->id, 'product_id' => $createdProducts[0]->id],
            [
                'seller_id' => $techSeller->id,
                'product_name' => $createdProducts[0]->name,
                'price' => $createdProducts[0]->price,
                'quantity' => 1,
                'subtotal' => $createdProducts[0]->price,
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $sampleOrder->id, 'product_id' => $createdProducts[7]->id],
            [
                'seller_id' => $techSeller->id,
                'product_name' => $createdProducts[7]->name,
                'price' => $createdProducts[7]->price,
                'quantity' => 1,
                'subtotal' => $createdProducts[7]->price,
            ]
        );

        // Order 2 (In processing)
        $sampleOrder2 = Order::firstOrCreate(
            ['order_number' => 'ORD-SHOPHUB002'],
            [
                'user_id' => $customer->id,
                'subtotal' => 189.50,
                'tax' => 9.48,
                'shipping_fee' => 0.00,
                'total_amount' => 198.98,
                'status' => 'processing',
                'payment_status' => 'paid',
                'payment_method' => 'upi',
                'shipping_name' => 'Sarah Jenkins',
                'shipping_email' => 'customer@shophub.com',
                'shipping_phone' => '+91 98765 11111',
                'shipping_address' => 'Flat 302, Green Valley Apartments',
                'shipping_city' => 'Pune',
                'shipping_postal_code' => '411001',
                'order_notes' => 'Call before arrival.',
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $sampleOrder2->id, 'product_id' => $createdProducts[3]->id],
            [
                'seller_id' => $fashionSeller->id,
                'product_name' => $createdProducts[3]->name,
                'price' => $createdProducts[3]->price,
                'quantity' => 1,
                'subtotal' => $createdProducts[3]->price,
            ]
        );
    }
}
