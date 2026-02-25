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
        ];

        foreach ($events as $event) {
            FoundationEvent::firstOrCreate(['slug' => $event['slug']], $event);
        }
    }
}
