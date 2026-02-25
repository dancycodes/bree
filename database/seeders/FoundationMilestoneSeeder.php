<?php

namespace Database\Seeders;

use App\Models\FoundationMilestone;
use Illuminate\Database\Seeder;

class FoundationMilestoneSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            [
                'year' => 2022,
                'title_fr' => 'Création de la Fondation BREE à Genève',
                'title_en' => 'Foundation of BREE in Geneva',
                'description_fr' => 'Anastasie Brenda BIYA fonde la Fondation BREE à Genève avec la mission de protéger les femmes et les enfants vulnérables en Afrique.',
                'description_en' => 'Anastasie Brenda BIYA founds the BREE Foundation in Geneva with the mission to protect vulnerable women and children in Africa.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'year' => 2023,
                'title_fr' => 'Lancement de BREE PROTÈGE',
                'title_en' => 'Launch of BREE PROTÈGE',
                'description_fr' => 'Lancement du programme BREE PROTÈGE, premiers enfants soutenus à travers des actions de protection et d\'accompagnement au Cameroun.',
                'description_en' => 'Launch of the BREE PROTÈGE program, first children supported through protection and mentoring actions in Cameroon.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'year' => 2024,
                'title_fr' => 'BREE ÉLÈVE : 20 premières bourses scolaires',
                'title_en' => 'BREE ÉLÈVE: First 20 scholarships',
                'description_fr' => 'Le programme BREE ÉLÈVE attribue ses 20 premières bourses scolaires à des orphelins et enfants vulnérables pour favoriser leur accès à l\'éducation.',
                'description_en' => 'The BREE ÉLÈVE program awards its first 20 scholarships to orphans and vulnerable children to support their access to education.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'year' => 2024,
                'title_fr' => 'Chantal BIYA nommée Marraine',
                'title_en' => 'Chantal BIYA appointed Patron',
                'description_fr' => 'Madame Chantal BIYA, Première Dame du Cameroun, accepte le rôle de Marraine de la Fondation BREE, renforçant sa visibilité et son impact.',
                'description_en' => 'Mrs. Chantal BIYA, First Lady of Cameroon, accepts the role of Patron of the BREE Foundation, strengthening its visibility and impact.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'year' => 2025,
                'title_fr' => 'Lancement de BREE RESPIRE',
                'title_en' => 'Launch of BREE RESPIRE',
                'description_fr' => 'Lancement du programme BREE RESPIRE dédié à la lutte contre la pollution environnementale, avec 10 nettoyages communautaires réalisés.',
                'description_en' => 'Launch of the BREE RESPIRE program dedicated to fighting environmental pollution, with 10 community cleanups completed.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'year' => 2026,
                'title_fr' => 'Conférence sur la Santé Mentale des Jeunes',
                'title_en' => 'Youth Mental Health Conference',
                'description_fr' => 'Organisation de la première conférence sur la santé mentale des jeunes en mars 2026, rassemblant experts et communautés pour un avenir plus sain.',
                'description_en' => 'Organization of the first Youth Mental Health Conference in March 2026, bringing together experts and communities for a healthier future.',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        // Seed via updateOrCreate and collect IDs of valid records
        $seededIds = [];
        foreach ($milestones as $data) {
            $milestone = FoundationMilestone::updateOrCreate(
                ['year' => $data['year'], 'sort_order' => $data['sort_order']],
                $data
            );
            $seededIds[] = $milestone->id;
        }

        // Remove any old placeholder milestones not in the real timeline
        FoundationMilestone::whereNotIn('id', $seededIds)->delete();
    }
}
