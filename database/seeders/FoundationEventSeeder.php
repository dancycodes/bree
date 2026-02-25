<?php

namespace Database\Seeders;

use App\Models\FoundationEvent;
use Illuminate\Database\Seeder;

class FoundationEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'slug' => 'journee-droits-femmes-mars-2026',
                'title_fr' => 'Journée Internationale des Droits des Femmes',
                'title_en' => 'International Women\'s Rights Day',
                'description_fr' => 'Cérémonie de sensibilisation et de remise de bourses aux femmes entrepreneures soutenues par la Fondation BREE.',
                'description_en' => 'Awareness ceremony and scholarship awards for women entrepreneurs supported by Fondation BREE.',
                'location_fr' => 'Yaoundé, Cameroun',
                'location_en' => 'Yaoundé, Cameroon',
                'event_date' => '2026-03-08',
                'event_time' => '10:00:00',
                'thumbnail_path' => 'images/sections/events-placeholder.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'gala-solidarite-geneve-avril-2026',
                'title_fr' => 'Gala de Solidarité — Genève 2026',
                'title_en' => 'Solidarity Gala — Geneva 2026',
                'description_fr' => 'Soirée annuelle de collecte de fonds en faveur des programmes BREE PROTÈGE et BREE ÉLÈVE.',
                'description_en' => 'Annual fundraising gala supporting the BREE PROTECTS and BREE EDUCATES programmes.',
                'location_fr' => 'Genève, Suisse',
                'location_en' => 'Geneva, Switzerland',
                'event_date' => '2026-04-18',
                'event_time' => '19:00:00',
                'thumbnail_path' => 'images/sections/events-placeholder.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'forum-education-inclusion-mai-2026',
                'title_fr' => 'Forum Éducation & Inclusion — Afrique Centrale',
                'title_en' => 'Education & Inclusion Forum — Central Africa',
                'description_fr' => 'Forum régional réunissant ONG, partenaires institutionnels et acteurs éducatifs autour des défis de l\'inclusion scolaire en Afrique.',
                'description_en' => 'Regional forum bringing together NGOs, institutional partners, and education stakeholders on school inclusion challenges in Africa.',
                'location_fr' => 'Douala, Cameroun',
                'location_en' => 'Douala, Cameroon',
                'event_date' => '2026-05-14',
                'event_time' => '09:00:00',
                'thumbnail_path' => 'images/sections/events-placeholder.jpg',
                'is_published' => true,
            ],
            // Past events
            [
                'slug' => 'atelier-sante-feminine-decembre-2025',
                'title_fr' => 'Atelier Santé Féminine & Droits Reproductifs',
                'title_en' => 'Women\'s Health & Reproductive Rights Workshop',
                'description_fr' => 'Atelier de sensibilisation destiné aux femmes rurales sur la santé reproductive, organisé en partenariat avec le Ministère de la Santé.',
                'description_en' => 'Awareness workshop for rural women on reproductive health, organized in partnership with the Ministry of Health.',
                'location_fr' => 'Bafoussam, Cameroun',
                'location_en' => 'Bafoussam, Cameroon',
                'event_date' => '2025-12-10',
                'event_time' => '09:00:00',
                'thumbnail_path' => 'images/sections/events-placeholder.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'ceremonie-remise-bourses-novembre-2025',
                'title_fr' => 'Cérémonie de Remise des Bourses BREE ÉLÈVE',
                'title_en' => 'BREE EDUCATES Scholarship Award Ceremony',
                'description_fr' => 'Remise officielle des bourses scolaires à 48 jeunes filles issues de familles vulnérables, en présence de partenaires institutionnels.',
                'description_en' => 'Official presentation of school scholarships to 48 girls from vulnerable families, in the presence of institutional partners.',
                'location_fr' => 'Yaoundé, Cameroun',
                'location_en' => 'Yaoundé, Cameroon',
                'event_date' => '2025-11-15',
                'event_time' => '10:30:00',
                'thumbnail_path' => 'images/sections/events-placeholder.jpg',
                'is_published' => true,
            ],
        ];

        foreach ($events as $event) {
            FoundationEvent::firstOrCreate(['slug' => $event['slug']], $event);
        }
    }
}
