<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FirstName' => $this->faker->firstName, // Generates a random first name
            'LastName' => $this->faker->lastName,   // Generates a random last name
            'Position' => $this->faker->jobTitle,   // Generates a random job title
            'Email' => $this->faker->unique()->safeEmail, // Generates a unique and safe email address
            'Phone' => $this->faker->phoneNumber,   // Generates a random phone number
            'Address' => $this->faker->address,     // Generates a random address
            'Salary' => $this->faker->numberBetween(30000, 80000), // Generates a salary between 30,000 and 80,000
            'DepartmentID' => Department::factory(), // Creates a related department record and assigns its ID
        ];
    }
}
