<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Restaurant;
use App\Models\RestaurantItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantItem>
 */
class RestaurantItemFactory extends Factory
{
    protected $model = RestaurantItem::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "uuid" => Str::uuid(),
            "restaurant_id" => $this->faker->randomElement(Restaurant::pluck("id")->toArray()),
            "item_id" => $this->faker->randomElement(Item::pluck("id")->toArray()),
            "price" => $this->faker->randomFloat(2,1,100)
        ];
    }
}
