<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsCategory>
 */
class NewsCategoryFactory extends Factory
{
    public function definition(): array
    {
        $nameFr = fake()->unique()->word();

        return [
            'name_fr' => ucfirst($nameFr),
            'name_en' => ucfirst(fake()->unique()->word()),
            'slug' => Str::slug($nameFr),
            'color' => fake()->hexColor(),
        ];
    }
}
