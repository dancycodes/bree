<?php

namespace Database\Seeders;

use App\Models\StatCounter;
use Illuminate\Database\Seeder;

class StatCounterSeeder extends Seeder
{
    public function run(): void
    {
        $counters = [
            [
                'sort_order' => 1,
                'number' => 1200,
                'label_fr' => 'enfants accompagnés',
                'label_en' => 'children supported',
                'icon_svg' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
                'is_active' => true,
            ],
            [
                'sort_order' => 2,
                'number' => 45,
                'label_fr' => 'bourses scolaires',
                'label_en' => 'scholarships awarded',
                'icon_svg' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                'is_active' => true,
            ],
            [
                'sort_order' => 3,
                'number' => 30,
                'label_fr' => 'nettoyages communautaires',
                'label_en' => 'community cleanups',
                'icon_svg' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
                'is_active' => true,
            ],
            [
                'sort_order' => 4,
                'number' => 5,
                'label_fr' => 'pays d\'intervention',
                'label_en' => 'countries of operation',
                'icon_svg' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
                'is_active' => true,
            ],
        ];

        foreach ($counters as $data) {
            StatCounter::updateOrCreate(
                ['sort_order' => $data['sort_order']],
                $data
            );
        }
    }
}
