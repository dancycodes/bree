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
                'excerpt_fr' => 'La Fondation BREE franchit une étape majeure avec le lancement officiel de BREE PROTÈGE, un programme d\'accompagnement juridique et psychologique pour les femmes victimes de violence.',
                'excerpt_en' => 'Fondation BREE reaches a major milestone with the official launch of BREE PROTECTS, a legal and psychological support programme for women victims of violence.',
                'category_fr' => 'Programmes',
                'category_en' => 'Programs',
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2026-02-10 09:00:00',
            ],
            [
                'slug' => 'partenariat-unicef-education-2026',
                'title_fr' => 'Nouveau partenariat avec l\'UNICEF pour l\'éducation des filles',
                'title_en' => 'New partnership with UNICEF for girls\' education',
                'excerpt_fr' => 'La Fondation BREE signe un accord de partenariat stratégique avec l\'UNICEF pour financer la scolarisation de 500 jeunes filles dans les régions rurales d\'Afrique centrale.',
                'excerpt_en' => 'Fondation BREE signs a strategic partnership agreement with UNICEF to fund schooling for 500 girls in rural regions of Central Africa.',
                'category_fr' => 'Partenariats',
                'category_en' => 'Partnerships',
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
                'thumbnail_path' => 'images/sections/news-placeholder.jpg',
                'status' => 'published',
                'published_at' => '2026-01-15 08:00:00',
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::firstOrCreate(['slug' => $article['slug']], $article);
        }
    }
}
