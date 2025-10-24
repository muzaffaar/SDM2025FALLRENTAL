<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'price' => $this->faker->randomFloat(2, 200, 1200),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'landlord_id' => 1, // Adjust for seeded landlord user
            'status' => 'available',
            'image_path' => 'images/sample-house.jpg',
        ];
    }
}
