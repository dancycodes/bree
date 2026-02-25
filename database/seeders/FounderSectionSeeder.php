<?php

namespace Database\Seeders;

use App\Models\FounderSection;
use Illuminate\Database\Seeder;

class FounderSectionSeeder extends Seeder
{
    public function run(): void
    {
        FounderSection::firstOrCreate(
            ['id' => 1],
            [
                'founder_name' => 'Brenda BIYA',
                'founder_title_fr' => 'Fondatrice & Présidente',
                'founder_title_en' => 'Founder & President',
                'founder_quote_fr' => 'Chaque enfant que nous aidons est une victoire sur l\'indifférence. Notre engagement, c\'est de ne jamais regarder ailleurs.',
                'founder_quote_en' => 'Every child we help is a victory against indifference. Our commitment is to never look away.',
                'founder_photo_path' => null,
                'patron_name' => 'Chantal BIYA',
                'patron_title_fr' => 'Marraine — Première Dame du Cameroun',
                'patron_title_en' => 'Patron — First Lady of Cameroon',
                'patron_quote_fr' => 'Aider ceux qui en ont besoin est pour moi un devoir de solidarité.',
                'patron_quote_en' => 'Helping those in need is for me a duty of solidarity.',
                'patron_photo_path' => null,
                'is_active' => true,
            ]
        );
    }
}
