<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin User',
            'email' => 'hatem@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '123-456-7890',
            'is_admin' => false,
            'is_active' => true,
        ]);


        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Shirts, pants, and other apparel',
                'is_active' => true,
            ],
            [
                'name' => 'Books',
                'description' => 'Physical and digital books',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Home appliances and kitchen tools',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }


        $products = [
            [
                'name' => 'Smartphone X',
                'description' => 'Latest smartphone with advanced features',
                'price' => 999.99,
                'stock' => 50,
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Pro',
                'description' => 'Powerful laptop for professionals',
                'price' => 1299.99,
                'stock' => 30,
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price' => 199.99,
                'stock' => 100,
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Men\'s T-Shirt',
                'description' => 'Comfortable cotton t-shirt for men',
                'price' => 24.99,
                'stock' => 200,
                'category_id' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Women\'s Jeans',
                'description' => 'Stylish jeans for women',
                'price' => 49.99,
                'stock' => 150,
                'category_id' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Programming Guide',
                'description' => 'Comprehensive guide to modern programming',
                'price' => 39.99,
                'stock' => 75,
                'category_id' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Coffee Maker',
                'description' => 'Automatic coffee maker for home use',
                'price' => 89.99,
                'stock' => 40,
                'category_id' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Blender',
                'description' => 'High-speed blender for smoothies and more',
                'price' => 69.99,
                'stock' => 60,
                'category_id' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }


        $user = User::find(2);

        $order1 = Order::create([
            'user_id' => $user->id,
            'status' => 'completed',
            'subtotal' => 1249.98,
            'tax' => 100.00,
            'total_amount' => 1349.98,
            'shipping_address' => '123 Main St',
            'shipping_city' => 'Anytown',
            'shipping_state' => 'CA',
            'shipping_postal_code' => '12345',
            'shipping_country' => 'USA',
            'billing_address' => '123 Main St',
            'billing_city' => 'Anytown',
            'billing_state' => 'CA',
            'billing_postal_code' => '12345',
            'billing_country' => 'USA',
        ]);


        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => 1,
            'price' => 999.99,
            'quantity' => 1,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => 3,
            'price' => 199.99,
            'quantity' => 1,
        ]);

        $order2 = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 89.99,
            'tax' => 7.20,
            'total_amount' => 97.19,
            'shipping_address' => '123 Main St',
            'shipping_city' => 'Anytown',
            'shipping_state' => 'CA',
            'shipping_postal_code' => '12345',
            'shipping_country' => 'USA',
            'billing_address' => '123 Main St',
            'billing_city' => 'Anytown',
            'billing_state' => 'CA',
            'billing_postal_code' => '12345',
            'billing_country' => 'USA',
        ]);


        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => 7,
            'price' => 89.99,
            'quantity' => 1,
        ]);
    }
}
