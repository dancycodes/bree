<?php

namespace Database\Seeders;

use App\Models\DonationCtaSection;
use Illuminate\Database\Seeder;

class DonationCtaSectionSeeder extends Seeder
{
    public function run(): void
    {
        DonationCtaSection::updateOrCreate(
            ['id' => 1],
            [
                'headline_fr' => 'Chaque geste compte',
                'headline_en' => 'Every gesture counts',
                'copy_fr' => 'Votre don, aussi petit soit-il, transforme des vies. Rejoignez des centaines de donateurs qui croient en un avenir meilleur pour les femmes et les enfants.',
                'copy_en' => 'Your donation, however small, transforms lives. Join hundreds of donors who believe in a better future for women and children.',
                'bg_image_path' => 'images/sections/donate.jpg',
                'is_active' => true,
            ]
        );
    }
}
