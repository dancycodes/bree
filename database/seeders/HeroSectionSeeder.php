<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'tagline_fr' => 'Agir aujourd\'hui pour transformer les rêves en réalités de demain.',
                'tagline_en' => 'Act today to transform dreams into tomorrow\'s realities.',
                'subtitle_fr' => 'Protéger. Élever. Inspirer. Pour un avenir plus humain.',
                'subtitle_en' => 'Protect. Elevate. Inspire. For a more human future.',
                'cta1_label_fr' => 'Faire un don',
                'cta1_label_en' => 'Make a Donation',
                'cta1_url' => '/faire-un-don',
                'cta2_label_fr' => 'Nos programmes',
                'cta2_label_en' => 'Our Programs',
                'cta2_url' => '/programmes',
                'bg_image_path' => 'images/sections/hero.jpg',
                'is_active' => true,
            ]
        );
    }
}
