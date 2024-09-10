<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'RoomNumber'=> $this->faker->unique()->numberBetween(100, 500),
    'RoomTypeID' => $this->faker->numberBetween(1, 3),
    'Capacity'=> $this->faker->numberBetween(1, 4),
    'PricePerNight' => $this->faker->numberBetween(50, 300),
    'Status' => $this->faker->boolean(80),
    'Floor' =>$this->faker->numberBetween(1, 20),
    'image' =>"1724923986.jpg",
    'ViewType' => $this->faker->randomElement(['Sea', 'City', 'Garden', 'Mountain']), // Example view types
    'Features' => $this->faker->words(3, true), // Generating random features as a string
        ];
    }
}
