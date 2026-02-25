<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tx_ref' => 'BREE-'.fake()->unique()->numerify('##########'),
            'flutterwave_id' => null,
            'amount' => fake()->randomElement([10, 25, 50, 100, 250]),
            'currency' => 'EUR',
            'type' => 'direct',
            'programme' => 'general',
            'donor_name' => fake()->name(),
            'donor_email' => fake()->safeEmail(),
            'donor_phone' => null,
            'donor_country' => 'CM',
            'status' => 'pending',
            'flutterwave_data' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'flutterwave_id' => (string) fake()->numerify('##########'),
            'status' => 'completed',
            'flutterwave_data' => ['status' => 'successful', 'amount' => $attributes['amount']],
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
        ]);
    }
}
