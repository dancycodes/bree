<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_fr' => 'Programmes',
                'name_en' => 'Programs',
                'slug' => 'programmes',
                'color' => '#c80078',
            ],
            [
                'name_fr' => 'Santé',
                'name_en' => 'Health',
                'slug' => 'sante',
                'color' => '#143c64',
            ],
            [
                'name_fr' => 'Environnement',
                'name_en' => 'Environment',
                'slug' => 'environnement',
                'color' => '#2d7a4a',
            ],
            [
                'name_fr' => 'Éducation',
                'name_en' => 'Education',
                'slug' => 'education',
                'color' => '#c8a03c',
            ],
            [
                'name_fr' => 'Partenariats',
                'name_en' => 'Partnerships',
                'slug' => 'partenariats',
                'color' => '#002850',
            ],
            [
                'name_fr' => 'Rapports',
                'name_en' => 'Reports',
                'slug' => 'rapports',
                'color' => '#475569',
            ],
            [
                'name_fr' => 'Dons',
                'name_en' => 'Donations',
                'slug' => 'dons',
                'color' => '#c8a03c',
            ],
        ];

        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
