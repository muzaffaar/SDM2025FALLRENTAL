<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RentalRequest>
 */
class RentalRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::factory()->create(['role' => 'student'])->id,
            'rental_id' => Rental::factory(),
            'status' => 'pending',
            'message' => $this->faker->sentence(),
        ];
    }
}
