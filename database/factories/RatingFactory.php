<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    protected $model = Rating::class;
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
            "user_id" => $this->faker->randomElement(User::pluck("id")->toArray()),
            "rate" => $this->faker->numberBetween(0,5),
            "comment" => $this->faker->text
        ];
    }
}
