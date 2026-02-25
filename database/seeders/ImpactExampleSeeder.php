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
                'description_fr' => 'un kit scolaire complet',
                'description_en' => 'a complete school kit',
                'icon' => 'book',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'amount' => 25,
                'description_fr' => 'un repas chaud pour 5 enfants',
                'description_en' => 'a hot meal for 5 children',
                'icon' => 'heart',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'amount' => 50,
                'description_fr' => 'une consultation médicale',
                'description_en' => 'a medical consultation',
                'icon' => 'shield',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'amount' => 100,
                'description_fr' => 'une bourse scolaire mensuelle',
                'description_en' => 'a monthly scholarship',
                'icon' => 'graduation-cap',
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($examples as $example) {
            ImpactExample::updateOrCreate(
                ['amount' => $example['amount']],
                $example
            );
        }

        // Remove the 250 CHF tier that is not part of the production spec
        ImpactExample::where('amount', 250)->delete();
    }
}
