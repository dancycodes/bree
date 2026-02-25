<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->partners() as $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                $partner
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function partners(): array
    {
        return [
            [
                'name' => 'Ministère de la Santé Publique du Cameroun',
                'description_fr' => 'Partenaire institutionnel pour les campagnes de santé publique.',
                'description_en' => 'Institutional partner for public health campaigns.',
                'website_url' => null,
                'logo_path' => 'images/partners/minsante.png',
                'type' => 'institutional',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Hôpital Jamot de Yaoundé',
                'description_fr' => 'Partenaire médical pour la Conférence Santé Mentale et les campagnes de santé.',
                'description_en' => 'Medical partner for the Mental Health Conference and health campaigns.',
                'website_url' => null,
                'logo_path' => 'images/partners/hopital-jamot.png',
                'type' => 'institutional',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Helvetas Swiss Intercooperation',
                'description_fr' => 'Partenaire technique suisse pour les programmes d\'alphabétisation.',
                'description_en' => 'Swiss technical partner for literacy programs.',
                'website_url' => 'https://www.helvetas.org',
                'logo_path' => 'images/partners/helvetas.png',
                'type' => 'technical',
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Rotary Club de Genève',
                'description_fr' => 'Partenaire financier pour les bourses scolaires BREE ÉLÈVE.',
                'description_en' => 'Financial partner for BREE ÉLÈVE scholarships.',
                'website_url' => null,
                'logo_path' => 'images/partners/rotary.png',
                'type' => 'financial',
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Centre d\'Ecologie Appliquée (CEA) Cameroun',
                'description_fr' => 'Partenaire environnemental pour les programmes BREE RESPIRE.',
                'description_en' => 'Environmental partner for BREE RESPIRE programs.',
                'website_url' => null,
                'logo_path' => 'images/partners/cea.png',
                'type' => 'technical',
                'is_published' => true,
                'sort_order' => 5,
            ],
        ];
    }
}
