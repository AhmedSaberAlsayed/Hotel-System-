<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Name' => $this->faker->name, // Generates a random first name
            'LoginType' => "normal",
            'Email' => $this->faker->unique()->safeEmail,
            'Password' => "123456789",
            'Phone'=> $this->faker->phoneNumber,
            'Address' => $this->faker->address,
            'LoyaltyPoints'=> 1,
            'MembershipLevel' => "bronze",

        ];
    }
}
