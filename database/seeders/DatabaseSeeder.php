<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(7)->create();
        Order::factory(5)->create();

        foreach (Order::all() as $order) {
            $products = Product::query()->take(rand(1,3))->pluck('id');
            $order->products()->attach($products);
        }
    }
}
