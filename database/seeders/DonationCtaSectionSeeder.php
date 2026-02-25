<?php

namespace Database\Seeders;

use App\Models\DonationCtaSection;
use Illuminate\Database\Seeder;

class DonationCtaSectionSeeder extends Seeder
{
    public function run(): void
    {
        DonationCtaSection::firstOrCreate(
            ['id' => 1],
            [
                'headline_fr' => 'Votre Générosité Change des Vies',
                'headline_en' => 'Your Generosity Changes Lives',
                'copy_fr' => 'Chaque don, grand ou petit, permet à la Fondation BREE de protéger des femmes, d\'éduquer des enfants et de préserver notre planète. Agissez aujourd\'hui.',
                'copy_en' => 'Every donation, big or small, enables Fondation BREE to protect women, educate children, and preserve our planet. Act today.',
                'bg_image_path' => 'images/sections/donate.jpg',
                'is_active' => true,
            ]
        );
    }
}
