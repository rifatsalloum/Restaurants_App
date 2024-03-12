<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "uuid" => Str::uuid(),
            "user_id" => $this->faker->randomElement(User::pluck("id")->toArray()),
            "type" => $this->faker->randomElement(["delivery","pickup"]),
            "status" => $this->faker->randomElement(["taked","not_taked"])
        ];
    }
}
