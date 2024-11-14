<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        Order::factory()->count(10)->create()->each(function ($order) use ($products) {
            $selectedProducts = $products->random(rand(1, 5));

            $total = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ]);

                $total += $orderItem->subtotal;
            }

            $order->update(['total' => $total]);
        });
    }
}
