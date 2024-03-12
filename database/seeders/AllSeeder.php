<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\RestaurantItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::factory()->count(10)->create();
        Item::factory()->count(10)->create();
        RestaurantItem::factory()->count(10)->create();
        Order::factory()->count(10)->create();
        OrderItem::factory()->count(10)->create();
        Rating::factory()->count(10)->create();
    }
}
