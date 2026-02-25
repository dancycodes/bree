<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->members() as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function members(): array
    {
        return [
            [
                'name' => 'Anastasie Brenda BIYA',
                'title_fr' => 'Présidente Fondatrice',
                'title_en' => 'Founding President',
                'bio_fr' => 'Fondatrice de la Fondation BREE, Anastasie Brenda BIYA œuvre depuis plus de dix ans pour la protection des enfants vulnérables et l\'émancipation des femmes en Afrique centrale.',
                'bio_en' => 'Founder of Fondation BREE, Anastasie Brenda BIYA has worked for over ten years to protect vulnerable children and empower women in Central Africa.',
                'photo_path' => 'images/team/president.jpg',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Claudine Mfoumou',
                'title_fr' => 'Directrice des Programmes',
                'title_en' => 'Programs Director',
                'bio_fr' => 'Spécialiste en développement social avec 12 ans d\'expérience en Afrique centrale.',
                'bio_en' => 'Social development specialist with 12 years of experience in Central Africa.',
                'photo_path' => 'images/team/team-01.jpg',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Ines Kamga Nana',
                'title_fr' => 'Responsable Communication',
                'title_en' => 'Communications Manager',
                'bio_fr' => 'Journaliste et communicante engagée pour la visibilité des causes sociales.',
                'bio_en' => 'Journalist and communications professional committed to raising visibility for social causes.',
                'photo_path' => 'images/team/team-02.jpg',
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Emmanuel Bekolo',
                'title_fr' => 'Coordinateur Terrain',
                'title_en' => 'Field Coordinator',
                'bio_fr' => 'Coordinateur de terrain avec expertise en logistique humanitaire au Cameroun.',
                'bio_en' => 'Field coordinator with expertise in humanitarian logistics in Cameroon.',
                'photo_path' => 'images/team/team-03.jpg',
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Miriam Essono',
                'title_fr' => 'Chargée des Partenariats',
                'title_en' => 'Partnerships Officer',
                'bio_fr' => 'Experte en relations institutionnelles et mobilisation de ressources.',
                'bio_en' => 'Expert in institutional relations and resource mobilization.',
                'photo_path' => 'images/team/team-04.jpg',
                'is_published' => true,
                'sort_order' => 5,
            ],
        ];
    }
}
