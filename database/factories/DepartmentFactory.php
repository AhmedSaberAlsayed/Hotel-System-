<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'DepartmentName' => $this->faker->company, // Generating a fake company name as department name
            'Description' => $this->faker->sentence, // A random sentence as description
            // 'ManagerID' =>  $this->faker->numberBetween(1, 10),
        ];
    }
}
