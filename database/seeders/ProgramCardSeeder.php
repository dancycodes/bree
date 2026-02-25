<?php

namespace Database\Seeders;

use App\Models\ProgramCard;
use Illuminate\Database\Seeder;

class ProgramCardSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'slug' => 'bree-protege',
                'name_fr' => 'BREE PROTÈGE',
                'name_en' => 'BREE PROTECTS',
                'description_fr' => 'Défendre les droits des femmes et des enfants vulnérables face à la violence, l\'exclusion et l\'injustice.',
                'description_en' => 'Defending the rights of vulnerable women and children against violence, exclusion, and injustice.',
                'image_path' => 'images/sections/program-protege.jpg',
                'color' => '#c80078',
                'url' => '/programmes/bree-protege',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'bree-eleve',
                'name_fr' => 'BREE ÉLÈVE',
                'name_en' => 'BREE EDUCATES',
                'description_fr' => 'Ouvrir l\'accès à l\'éducation, à la formation professionnelle et à l\'autonomisation économique pour toutes.',
                'description_en' => 'Opening access to education, vocational training, and economic empowerment for all.',
                'image_path' => 'images/sections/program-eleve.jpg',
                'color' => '#143c64',
                'url' => '/programmes/bree-eleve',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'bree-respire',
                'name_fr' => 'BREE RESPIRE',
                'name_en' => 'BREE BREATHES',
                'description_fr' => 'Promouvoir la santé communautaire, l\'environnement durable et le bien-être des générations futures.',
                'description_en' => 'Promoting community health, sustainable environment, and the well-being of future generations.',
                'image_path' => 'images/sections/program-respire.jpg',
                'color' => '#c8a03c',
                'url' => '/programmes/bree-respire',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            ProgramCard::firstOrCreate(['slug' => $program['slug']], $program);
        }
    }
}
