<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsArticle>
 */
class NewsArticleFactory extends Factory
{
    public function definition(): array
    {
        $titleFr = fake()->sentence(5);

        return [
            'slug' => Str::slug($titleFr).'-'.fake()->unique()->randomNumber(4),
            'title_fr' => $titleFr,
            'title_en' => fake()->sentence(5),
            'excerpt_fr' => fake()->paragraph(),
            'excerpt_en' => fake()->paragraph(),
            'content_fr' => fake()->paragraphs(3, true),
            'content_en' => fake()->paragraphs(3, true),
            'category_fr' => 'Actualités',
            'category_en' => 'News',
            'category_slug' => null,
            'thumbnail_path' => null,
            'status' => 'published',
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft', 'published_at' => null]);
    }
}
