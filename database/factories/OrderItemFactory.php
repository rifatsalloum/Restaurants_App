<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "uuid" => Str::uuid(),
            "order_id" => $this->faker->randomElement(Order::pluck("id")->toArray()),
            "restaurant_item_id" => $this->faker->randomElement(RestaurantItem::pluck("id")->toArray()),
            "price" => $this->faker->randomFloat(2,1,100),
            "number" => $this->faker->numberBetween(1,10)
        ];
    }
}
