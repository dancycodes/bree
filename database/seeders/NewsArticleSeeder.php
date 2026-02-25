<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'slug' => 'lancement-programme-bree-protege-2025',
                'title_fr' => 'Lancement du programme BREE PROTÈGE : 300 familles accompagnées',
                'title_en' => 'Launch of BREE PROTECTS programme: 300 families supported',
                'excerpt_fr' => "La Fondation BREE franchit une étape majeure avec le lancement officiel de BREE PROTÈGE, un programme d'accompagnement juridique et psychologique pour les femmes victimes de violence.",
                'excerpt_en' => 'Fondation BREE reaches a major milestone with the official launch of BREE PROTECTS, a legal and psychological support programme for women victims of violence.',
                'category_fr' => 'Programmes',
                'category_en' => 'Programs',
                'category_slug' => 'programmes',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2026-02-10 09:00:00',
            ],
            [
                'slug' => 'partenariat-unicef-education-2026',
                'title_fr' => "Nouveau partenariat avec l'UNICEF pour l'éducation des filles",
                'title_en' => "New partnership with UNICEF for girls' education",
                'excerpt_fr' => "La Fondation BREE signe un accord de partenariat stratégique avec l'UNICEF pour financer la scolarisation de 500 jeunes filles dans les régions rurales d'Afrique centrale.",
                'excerpt_en' => 'Fondation BREE signs a strategic partnership agreement with UNICEF to fund schooling for 500 girls in rural regions of Central Africa.',
                'category_fr' => 'Partenariats',
                'category_en' => 'Partnerships',
                'category_slug' => 'partenariats',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2026-01-28 10:30:00',
            ],
            [
                'slug' => 'campagne-nettoyage-environnement-janvier-2026',
                'title_fr' => 'BREE RESPIRE : 1 200 volontaires pour un environnement plus propre',
                'title_en' => 'BREE BREATHES: 1,200 volunteers for a cleaner environment',
                'excerpt_fr' => 'Plus de 1 200 volontaires ont participé aux campagnes de nettoyage organisées dans 12 villes en janvier 2026. Un élan communautaire sans précédent pour la Fondation BREE.',
                'excerpt_en' => 'More than 1,200 volunteers participated in cleanup campaigns organized in 12 cities in January 2026. An unprecedented community momentum for Fondation BREE.',
                'category_fr' => 'Environnement',
                'category_en' => 'Environment',
                'category_slug' => 'environnement',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2026-01-15 08:00:00',
            ],
            [
                'slug' => 'rapport-annuel-2025-bilan-impact',
                'title_fr' => 'Rapport annuel 2025 : un bilan de 10 000 vies transformées',
                'title_en' => 'Annual Report 2025: a review of 10,000 lives transformed',
                'excerpt_fr' => "Notre rapport annuel 2025 démontre l'impact concret de nos actions : 10 000 bénéficiaires directs, 3 continents touchés et des résultats mesurables dans chaque programme.",
                'excerpt_en' => 'Our 2025 annual report demonstrates the concrete impact of our actions: 10,000 direct beneficiaries, 3 continents reached and measurable results in every programme.',
                'category_fr' => 'Rapports',
                'category_en' => 'Reports',
                'category_slug' => 'rapports',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2025-12-20 11:00:00',
            ],
            [
                'slug' => 'formation-droits-femmes-douala-2025',
                'title_fr' => 'Formation aux droits des femmes : 200 participantes à Douala',
                'title_en' => "Women's rights training: 200 participants in Douala",
                'excerpt_fr' => 'Deux cent femmes ont suivi notre formation intensive de trois jours sur la connaissance de leurs droits fondamentaux. Un programme développé en partenariat avec le Barreau du Cameroun.',
                'excerpt_en' => 'Two hundred women attended our intensive three-day training on knowledge of their fundamental rights. A programme developed in partnership with the Cameroon Bar Association.',
                'category_fr' => 'Programmes',
                'category_en' => 'Programs',
                'category_slug' => 'programmes',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2025-11-05 09:30:00',
            ],
            [
                'slug' => 'appel-dons-rentrée-scolaire-2025',
                'title_fr' => 'Appel aux dons pour la rentrée scolaire : aidez 150 enfants à étudier',
                'title_en' => 'Donation appeal for the school year: help 150 children study',
                'excerpt_fr' => "À l'approche de la rentrée scolaire, la Fondation BREE lance un appel à la générosité pour couvrir les frais de scolarité de 150 enfants issus de familles vulnérables.",
                'excerpt_en' => 'As the new school year approaches, Fondation BREE launches an appeal for generosity to cover the school fees of 150 children from vulnerable families.',
                'category_fr' => 'Dons',
                'category_en' => 'Donations',
                'category_slug' => 'dons',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2025-08-22 10:00:00',
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::firstOrCreate(['slug' => $article['slug']], $article);
        }
    }
}
