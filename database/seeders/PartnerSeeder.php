<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Ministère de la Femme et de la Famille',
                'description_fr' => 'Partenaire institutionnel engagé dans la promotion des droits des femmes et la protection de la famille au Cameroun.',
                'description_en' => 'Institutional partner committed to promoting women\'s rights and family protection in Cameroon.',
                'website_url' => null,
                'type' => 'institutional',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'UNICEF Cameroun',
                'description_fr' => 'Partenaire international dédié à la protection et au bien-être des enfants à travers le monde.',
                'description_en' => 'International partner dedicated to the protection and well-being of children worldwide.',
                'website_url' => 'https://www.unicef.org/cameroon',
                'type' => 'institutional',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Orange Cameroun',
                'description_fr' => 'Partenaire financier soutenant nos programmes d\'accès au numérique pour les jeunes filles.',
                'description_en' => 'Financial partner supporting our digital access programs for young girls.',
                'website_url' => null,
                'type' => 'financial',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Fondation Française pour la Femme',
                'description_fr' => 'Partenaire financier contribuant au financement de nos bourses d\'études.',
                'description_en' => 'Financial partner contributing to the funding of our scholarships.',
                'website_url' => null,
                'type' => 'financial',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'École Polytechnique de Yaoundé',
                'description_fr' => 'Partenaire technique offrant des formations et du mentorat en STEM pour les bénéficiaires de nos programmes.',
                'description_en' => 'Technical partner offering STEM training and mentoring for our program beneficiaries.',
                'website_url' => null,
                'type' => 'technical',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Cabinet PsyAfrique',
                'description_fr' => 'Partenaire technique fournissant un soutien psychologique professionnel à nos bénéficiaires.',
                'description_en' => 'Technical partner providing professional psychological support to our beneficiaries.',
                'website_url' => null,
                'type' => 'technical',
                'is_published' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}
