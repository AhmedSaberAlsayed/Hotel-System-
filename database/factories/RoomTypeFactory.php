<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'RoomTypeName'=> $this->faker->randomElement(['Single', 'Double', 'Suite']),
        'Description'=> $this->faker->sentence,
        'BasePrice'=> $this->faker->numberBetween(50, 300),
        ];
    }
}
