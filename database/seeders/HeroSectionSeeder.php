<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::firstOrCreate(
            ['id' => 1],
            [
                'tagline_fr' => 'Protéger. Élever. Inspirer.',
                'tagline_en' => 'Protect. Elevate. Inspire.',
                'subtitle_fr' => 'La Fondation BREE œuvre pour la protection et l\'épanouissement des femmes et des enfants vulnérables en Afrique.',
                'subtitle_en' => 'The BREE Foundation works for the protection and flourishing of vulnerable women and children in Africa.',
                'cta1_label_fr' => 'Découvrir nos programmes',
                'cta1_label_en' => 'Discover our programmes',
                'cta1_url' => '/programmes',
                'cta2_label_fr' => 'Faire un Don',
                'cta2_label_en' => 'Make a Donation',
                'cta2_url' => '/don',
                'bg_image_path' => 'images/sections/hero.jpg',
                'is_active' => true,
            ]
        );
    }
}
