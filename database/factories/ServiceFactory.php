<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ServiceName' => $this->faker->word, // Generates a random word as service name
            'ServiceDescription' => $this->faker->sentence, // Generates a random sentence as service description
            'ServicePrice' => $this->faker->numberBetween(10, 500), // Generates a price between 10 and 500
            'ServiceCategory' => $this->faker->randomElement(['Consulting', 'Maintenance', 'Installation', 'Support']), // Random category
        ];
    }
}
