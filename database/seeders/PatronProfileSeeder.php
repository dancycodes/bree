<?php

namespace Database\Seeders;

use App\Models\PatronProfile;
use Illuminate\Database\Seeder;

class PatronProfileSeeder extends Seeder
{
    public function run(): void
    {
        PatronProfile::updateOrCreate(
            ['name' => 'Chantal BIYA'],
            [
                'title_fr' => 'Première Dame du Cameroun',
                'title_en' => 'First Lady of Cameroon',
                'role_fr' => 'Marraine de la Fondation BREE',
                'role_en' => 'Patron of Fondation BREE',
                'description_fr' => 'En tant que Marraine de la FONDATION BREE, elle renforce la portée humanitaire de nos actions et accompagne l\'ambition d\'impact social durable que nous portons.',
                'description_en' => 'As Patron of FONDATION BREE, she strengthens the humanitarian reach of our actions and supports our ambition for lasting social impact.',
                'quote_fr' => 'Aider ceux qui en ont besoin est pour moi un devoir de solidarité',
                'quote_en' => 'Helping those in need is, for me, a duty of solidarity',
                'photo_path' => 'images/team/patron.jpg',
                'is_active' => true,
            ]
        );
    }
}
