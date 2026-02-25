<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecurringDonation>
 */
class RecurringDonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tx_ref' => 'BREE-R-'.fake()->unique()->numerify('##########'),
            'flutterwave_plan_id' => null,
            'flutterwave_subscription_id' => null,
            'amount' => fake()->randomElement([10, 20, 30, 50]),
            'currency' => 'EUR',
            'frequency' => fake()->randomElement(['monthly', 'yearly']),
            'programme' => 'general',
            'donor_name' => fake()->name(),
            'donor_email' => fake()->safeEmail(),
            'donor_phone' => null,
            'donor_country' => 'CM',
            'status' => 'pending',
            'flutterwave_data' => null,
            'cancelled_at' => null,
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'flutterwave_plan_id' => (string) fake()->numerify('######'),
            'flutterwave_subscription_id' => (string) fake()->numerify('######'),
            'status' => 'active',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
