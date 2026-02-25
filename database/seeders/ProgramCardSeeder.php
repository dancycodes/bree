<?php

namespace Database\Seeders;

use App\Models\ProgramActivity;
use App\Models\ProgramCard;
use Illuminate\Database\Seeder;

class ProgramCardSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->programs() as $p) {
            $activities = $p['_activities'] ?? [];
            unset($p['_activities']);

            $card = ProgramCard::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );

            foreach ($activities as $i => $a) {
                ProgramActivity::updateOrCreate(
                    ['program_card_id' => $card->id, 'name_fr' => $a['name_fr']],
                    ['name_en' => $a['name_en'], 'sort_order' => $i + 1, 'is_active' => true]
                );
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function programs(): array
    {
        return [
            [
                'slug' => 'bree-protege',
                'name_fr' => 'BREE PROTÈGE',
                'name_en' => 'BREE PROTECTS',
                'description_fr' => 'Nous protégeons les enfants orphelins et vulnérables en leur garantissant accès à la santé, un soutien psychologique et un environnement sécurisé.',
                'description_en' => 'We protect orphaned and vulnerable children by ensuring access to healthcare, psychological support, and a safe environment.',
                'long_description_fr' => 'BREE PROTÈGE est le pilier humanitaire de la Fondation. Face à la détresse des enfants privés de famille ou exposés à la violence, nous intervenons directement pour garantir leur dignité, leur santé et leur avenir.',
                'long_description_en' => 'BREE PROTECTS is the humanitarian pillar of the Foundation. Faced with the distress of children deprived of family or exposed to violence, we intervene directly to guarantee their dignity, health, and future.',
                'activities_fr' => ['Protection des orphelins', 'Accès à la santé', 'Prévention des maladies', 'Soutien psychologique'],
                'activities_en' => ['Orphan protection', 'Healthcare access', 'Disease prevention', 'Psychological support'],
                'stats_fr' => [
                    ['number' => '800+', 'label' => 'Enfants protégés'],
                    ['number' => '1 200+', 'label' => 'Consultations médicales'],
                    ['number' => '5', 'label' => 'Partenaires santé'],
                ],
                'stats_en' => [
                    ['number' => '800+', 'label' => 'Children protected'],
                    ['number' => '1,200+', 'label' => 'Medical consultations'],
                    ['number' => '5', 'label' => 'Health partners'],
                ],
                'image_path' => 'images/sections/bree-protege.jpg',
                'color' => '#c80078',
                'url' => '/programmes/bree-protege',
                'sort_order' => 1,
                'is_active' => true,
                '_activities' => [
                    ['name_fr' => 'Protection des orphelins', 'name_en' => 'Orphan protection'],
                    ['name_fr' => 'Accès à la santé', 'name_en' => 'Healthcare access'],
                    ['name_fr' => 'Prévention des maladies', 'name_en' => 'Disease prevention'],
                    ['name_fr' => 'Soutien psychologique', 'name_en' => 'Psychological support'],
                ],
            ],
            [
                'slug' => 'bree-eleve',
                'name_fr' => 'BREE ÉLÈVE',
                'name_en' => 'BREE ELEVATES',
                'description_fr' => 'Nous croyons que l'."'".'éducation est le levier le plus puissant contre la pauvreté. BREE ÉLÈVE accompagne les filles et les femmes vers l'."'".'autonomie par la scolarisation et la formation.',
                'description_en' => 'We believe education is the most powerful lever against poverty. BREE ELEVATES supports girls and women toward independence through schooling and training.',
                'long_description_fr' => 'Grâce à des bourses scolaires, des clubs éducatifs et des programmes d'."'".'alphabétisation, BREE ÉLÈVE redonne aux filles le droit d'."'".'apprendre et aux femmes le pouvoir d'."'".'agir.',
                'long_description_en' => 'Through scholarships, educational clubs, and literacy programs, BREE ELEVATES gives girls the right to learn and women the power to act.',
                'activities_fr' => ['Bourses scolaires', 'Alphabétisation des filles', 'Autonomisation des femmes', 'Clubs éducatifs'],
                'activities_en' => ['Scholarships', 'Girls'."'".' literacy', 'Women'."'".'s empowerment', 'Educational clubs'],
                'stats_fr' => [
                    ['number' => '45', 'label' => 'Bourses attribuées'],
                    ['number' => '200+', 'label' => 'Filles scolarisées'],
                    ['number' => '120+', 'label' => 'Femmes formées'],
                ],
                'stats_en' => [
                    ['number' => '45', 'label' => 'Scholarships awarded'],
                    ['number' => '200+', 'label' => 'Girls enrolled'],
                    ['number' => '120+', 'label' => 'Women trained'],
                ],
                'image_path' => 'images/sections/bree-eleve.jpg',
                'color' => '#143c64',
                'url' => '/programmes/bree-eleve',
                'sort_order' => 2,
                'is_active' => true,
                '_activities' => [
                    ['name_fr' => 'Bourses scolaires', 'name_en' => 'Scholarships'],
                    ['name_fr' => 'Alphabétisation des filles', 'name_en' => 'Girls'."'".' literacy'],
                    ['name_fr' => 'Autonomisation des femmes', 'name_en' => 'Women'."'".'s empowerment'],
                    ['name_fr' => 'Clubs éducatifs', 'name_en' => 'Educational clubs'],
                ],
            ],
            [
                'slug' => 'bree-respire',
                'name_fr' => 'BREE RESPIRE',
                'name_en' => 'BREE BREATHES',
                'description_fr' => 'La pollution menace nos communautés. BREE RESPIRE mobilise citoyens et partenaires pour un cadre de vie plus sain, à travers des nettoyages, le recyclage et l'."'".'éducation environnementale.',
                'description_en' => 'Pollution threatens our communities. BREE BREATHES mobilizes citizens and partners for a healthier environment through cleanups, recycling, and environmental education.',
                'long_description_fr' => 'Chaque action environnementale est un acte d'."'".'amour envers les générations futures. BREE RESPIRE organise des nettoyages communautaires, sensibilise aux déchets zéro et crée des espaces verts là où il n'."'".'y en avait pas.',
                'long_description_en' => 'Every environmental action is an act of love for future generations. BREE BREATHES organizes community cleanups, raises awareness about zero waste, and creates green spaces where there were none.',
                'activities_fr' => ['Lutte contre la pollution', 'Nettoyages communautaires', 'Recyclages', 'Ateliers zéro déchets'],
                'activities_en' => ['Anti-pollution action', 'Community cleanups', 'Recycling drives', 'Zero-waste workshops'],
                'stats_fr' => [
                    ['number' => '30+', 'label' => 'Nettoyages organisés'],
                    ['number' => '12', 'label' => 'Tonnes de déchets collectés'],
                    ['number' => '450+', 'label' => 'Volontaires mobilisés'],
                ],
                'stats_en' => [
                    ['number' => '30+', 'label' => 'Cleanups organized'],
                    ['number' => '12', 'label' => 'Tons of waste collected'],
                    ['number' => '450+', 'label' => 'Volunteers mobilized'],
                ],
                'image_path' => 'images/sections/bree-respire.jpg',
                'color' => '#c8a03c',
                'url' => '/programmes/bree-respire',
                'sort_order' => 3,
                'is_active' => true,
                '_activities' => [
                    ['name_fr' => 'Lutte contre la pollution', 'name_en' => 'Anti-pollution action'],
                    ['name_fr' => 'Nettoyages communautaires', 'name_en' => 'Community cleanups'],
                    ['name_fr' => 'Recyclages', 'name_en' => 'Recycling drives'],
                    ['name_fr' => 'Ateliers zéro déchets', 'name_en' => 'Zero-waste workshops'],
                ],
            ],
        ];
    }
}
