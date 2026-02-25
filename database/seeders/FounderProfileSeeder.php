<?php

namespace Database\Seeders;

use App\Models\FounderProfile;
use Illuminate\Database\Seeder;

class FounderProfileSeeder extends Seeder
{
    public function run(): void
    {
        FounderProfile::updateOrCreate(
            ['name' => 'Anastasie Brenda BIYA'],
            [
                'title_fr' => 'Présidente Fondatrice',
                'title_en' => 'Founding President',
                'bio_fr' => 'Militante sociale engagée pour la dignité humaine, la justice sociale et la protection des plus vulnérables',
                'bio_en' => 'A social activist committed to human dignity, social justice, and the protection of the most vulnerable',
                'message_fr' => "Elle porte une vision nouvelle : transformer l'espoir en action, et permettre aux femmes et aux enfants d'écrire leur avenir.",
                'message_en' => 'She carries a new vision: transforming hope into action, and enabling women and children to write their own future.',
                'photo_path' => 'images/team/founder.jpg',
                'is_active' => true,
            ]
        );

        // Remove any old placeholder record with the previous name
        FounderProfile::query()
            ->where('name', 'Brenda BIYA')
            ->where('name', '!=', 'Anastasie Brenda BIYA')
            ->delete();
    }
}
