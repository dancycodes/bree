<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InKindDonation>
 */
class InKindDonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'donor_name' => fake()->name(),
            'organization' => fake()->optional()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'donation_type' => fake()->randomElement(['goods', 'services', 'expertise', 'other']),
            'description' => fake()->sentences(2, true),
            'estimated_value' => fake()->optional()->randomFloat(2, 10, 5000),
            'programme' => fake()->optional()->randomElement(['bree-protege', 'bree-eleve', 'bree-respire']),
            'availability' => fake()->optional()->sentence(),
            'status' => 'pending_review',
        ];
    }
}
