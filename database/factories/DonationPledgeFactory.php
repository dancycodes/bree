<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationPledge>
 */
class DonationPledgeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'amount' => fake()->randomFloat(2, 10, 500),
            'currency' => 'EUR',
            'nature' => fake()->randomElement(['monetary', 'in_kind']),
            'programme' => fake()->randomElement(['bree-protege', 'bree-eleve', 'bree-respire', null]),
            'message' => fake()->optional()->sentence(),
            'status' => 'pending',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(['status' => 'confirmed']);
    }

    public function inKind(): static
    {
        return $this->state(['nature' => 'in_kind', 'amount' => null]);
    }
}
