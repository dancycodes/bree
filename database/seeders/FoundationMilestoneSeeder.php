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
                'year' => 2015,
                'title_fr' => 'Naissance de la vision',
                'title_en' => 'Birth of the vision',
                'description_fr' => "La Fondation BREE est née d'une conviction profonde : chaque femme, chaque enfant mérite protection, éducation et dignité. Nos fondatrices posent les premières pierres d'une organisation vouée à l'humanité.",
                'description_en' => 'The BREE Foundation was born from a deep conviction: every woman, every child deserves protection, education and dignity. Our founders laid the first stones of an organization dedicated to humanity.',
                'sort_order' => 1,
            ],
            [
                'year' => 2016,
                'title_fr' => 'Premiers programmes sur le terrain',
                'title_en' => 'First field programmes',
                'description_fr' => 'Lancement des premières interventions au Cameroun : bourses scolaires pour 120 filles en zones rurales et sensibilisation contre les violences faites aux femmes dans 5 communautés.',
                'description_en' => 'Launch of first interventions in Cameroon: scholarships for 120 girls in rural areas and awareness-raising against violence against women in 5 communities.',
                'sort_order' => 2,
            ],
            [
                'year' => 2018,
                'title_fr' => 'Reconnaissance internationale',
                'title_en' => 'International recognition',
                'description_fr' => "La Fondation obtient le statut consultatif auprès des Nations Unies et étend ses programmes à trois nouveaux pays d'Afrique subsaharienne.",
                'description_en' => 'The Foundation obtains consultative status with the United Nations and extends its programmes to three new sub-Saharan African countries.',
                'sort_order' => 3,
            ],
            [
                'year' => 2020,
                'title_fr' => 'BREE RESPIRE — Urgence climatique',
                'title_en' => 'BREE BREATHES — Climate emergency',
                'description_fr' => 'Face à la crise climatique, la Fondation lance BREE RESPIRE, un programme dédié à la santé environnementale et au bien-être des communautés les plus exposées.',
                'description_en' => 'Facing the climate crisis, the Foundation launches BREE BREATHES, a programme dedicated to environmental health and the well-being of the most exposed communities.',
                'sort_order' => 4,
            ],
            [
                'year' => 2023,
                'title_fr' => '10 000 bénéficiaires',
                'title_en' => '10,000 beneficiaries',
                'description_fr' => "Milestone historique : la Fondation BREE franchit le cap des 10 000 bénéficiaires directs à travers l'ensemble de ses programmes, sur 3 continents.",
                'description_en' => 'Historic milestone: the BREE Foundation surpasses 10,000 direct beneficiaries across all its programmes, on 3 continents.',
                'sort_order' => 5,
            ],
        ];

        foreach ($milestones as $data) {
            FoundationMilestone::firstOrCreate(
                ['year' => $data['year'], 'title_fr' => $data['title_fr']],
                $data
            );
        }
    }
}
