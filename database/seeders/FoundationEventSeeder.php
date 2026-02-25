<?php

namespace Database\Seeders;

use App\Models\FoundationEvent;
use Illuminate\Database\Seeder;

class FoundationEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            // ── Upcoming events ──────────────────────────────────────────────
            [
                'slug' => 'conference-sante-mentale-mars-2026',
                'title_fr' => 'Conférence : Santé Mentale des Jeunes',
                'title_en' => 'Conference: Youth Mental Health',
                'description_fr' => 'Une conférence réunissant professionnels de santé, éducateurs et acteurs sociaux pour aborder la santé mentale des jeunes au Cameroun.',
                'description_en' => 'A conference bringing together health professionals, educators, and social workers to address youth mental health in Cameroon.',
                'location_fr' => 'Hôpital Jamot de Yaoundé, Cameroun',
                'location_en' => 'Hôpital Jamot, Yaoundé, Cameroon',
                'event_date' => '2026-03-04',
                'event_time' => '09:00:00',
                'end_date' => '2026-03-04',
                'end_time' => '17:00:00',
                'max_capacity' => 300,
                'registration_required' => true,
                'thumbnail_path' => 'images/events/conference-sante-mentale.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'journee-femme-bree-eleve-2026',
                'title_fr' => 'Journée Mondiale de la Femme — BREE ÉLÈVE',
                'title_en' => "International Women's Day — BREE ELEVATES",
                'description_fr' => "Célébration et remise de bourses scolaires à l'occasion de la Journée Mondiale de la Femme.",
                'description_en' => "Celebration and scholarship ceremony on International Women's Day.",
                'location_fr' => 'Yaoundé, Cameroun',
                'location_en' => 'Yaoundé, Cameroon',
                'event_date' => '2026-03-08',
                'event_time' => '10:00:00',
                'end_date' => null,
                'end_time' => null,
                'max_capacity' => 150,
                'registration_required' => false,
                'thumbnail_path' => 'images/events/journee-femme.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'nettoyage-bree-respire-avril-2026',
                'title_fr' => 'Nettoyage Communautaire — BREE RESPIRE',
                'title_en' => 'Community Cleanup — BREE BREATHES',
                'description_fr' => "À l'occasion de la Journée de la Terre, BREE RESPIRE organise une grande opération de nettoyage en partenariat avec les mairies locales.",
                'description_en' => 'On Earth Day, BREE BREATHES organizes a large cleanup operation in partnership with local municipalities.',
                'location_fr' => 'Plusieurs quartiers de Yaoundé, Cameroun',
                'location_en' => 'Various neighbourhoods of Yaoundé, Cameroon',
                'event_date' => '2026-04-22',
                'event_time' => '08:00:00',
                'end_date' => null,
                'end_time' => null,
                'max_capacity' => null,
                'registration_required' => false,
                'thumbnail_path' => 'images/events/nettoyage-communautaire.jpg',
                'is_published' => true,
            ],
            // ── Past events ──────────────────────────────────────────────────
            [
                'slug' => 'distribution-fournitures-jan-2026',
                'title_fr' => 'Distribution de fournitures scolaires',
                'title_en' => 'School Supplies Distribution',
                'description_fr' => 'Distribution de kits scolaires aux enfants issus de milieux défavorisés dans le cadre du programme BREE ÉLÈVE.',
                'description_en' => 'Distribution of school kits to children from disadvantaged backgrounds as part of the BREE EDUCATES programme.',
                'location_fr' => 'Yaoundé, Cameroun',
                'location_en' => 'Yaoundé, Cameroon',
                'event_date' => '2026-01-15',
                'event_time' => '09:00:00',
                'end_date' => null,
                'end_time' => null,
                'max_capacity' => null,
                'registration_required' => false,
                'thumbnail_path' => 'images/events/distribution-fournitures.jpg',
                'is_published' => true,
            ],
            [
                'slug' => 'campagne-vaccination-dec-2025',
                'title_fr' => 'Campagne de vaccination — BREE PROTÈGE',
                'title_en' => 'Vaccination Campaign — BREE PROTECTS',
                'description_fr' => 'Campagne de vaccination mobile organisée par BREE PROTÈGE en partenariat avec les autorités sanitaires de Douala et Yaoundé.',
                'description_en' => 'Mobile vaccination campaign organized by BREE PROTECTS in partnership with health authorities in Douala and Yaoundé.',
                'location_fr' => 'Douala et Yaoundé, Cameroun',
                'location_en' => 'Douala and Yaoundé, Cameroon',
                'event_date' => '2025-12-10',
                'event_time' => '08:00:00',
                'end_date' => null,
                'end_time' => null,
                'max_capacity' => null,
                'registration_required' => false,
                'thumbnail_path' => 'images/events/campagne-vaccination.jpg',
                'is_published' => true,
            ],
        ];

        foreach ($events as $event) {
            FoundationEvent::updateOrCreate(
                ['slug' => $event['slug']],
                $event,
            );
        }
    }
}
