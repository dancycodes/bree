<?php

namespace Database\Seeders;

use App\Models\ImpactExample;
use Illuminate\Database\Seeder;

class ImpactExampleSeeder extends Seeder
{
    public function run(): void
    {
        $examples = [
            [
                'amount' => 10,
                'description_fr' => 'offre des fournitures scolaires à un enfant pour un trimestre',
                'description_en' => 'provides school supplies to a child for one term',
                'icon' => 'book',
                'sort_order' => 1,
            ],
            [
                'amount' => 25,
                'description_fr' => 'finance une consultation médicale pour une femme en difficulté',
                'description_en' => 'funds a medical consultation for a woman in need',
                'icon' => 'heart',
                'sort_order' => 2,
            ],
            [
                'amount' => 50,
                'description_fr' => 'soutient un mois d\'accompagnement psychologique pour une victime',
                'description_en' => 'supports one month of psychological support for a victim',
                'icon' => 'shield',
                'sort_order' => 3,
            ],
            [
                'amount' => 100,
                'description_fr' => 'finance une bourse scolaire complète pour un trimestre',
                'description_en' => 'funds a full school scholarship for one term',
                'icon' => 'book',
                'sort_order' => 4,
            ],
            [
                'amount' => 250,
                'description_fr' => 'finance la formation professionnelle d\'une femme entrepreneur',
                'description_en' => 'finances professional training for a women entrepreneur',
                'icon' => 'leaf',
                'sort_order' => 5,
            ],
        ];

        foreach ($examples as $example) {
            ImpactExample::firstOrCreate(['amount' => $example['amount']], $example);
        }
    }
}
