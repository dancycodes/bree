<?php

namespace Database\Seeders;

use App\Models\PatronProfile;
use Illuminate\Database\Seeder;

class PatronProfileSeeder extends Seeder
{
    public function run(): void
    {
        PatronProfile::firstOrCreate(
            ['name' => 'Chantal BIYA'],
            [
                'title_fr' => 'Première Dame de la République du Cameroun',
                'title_en' => 'First Lady of the Republic of Cameroon',
                'role_fr' => 'Marraine de la Fondation BREE',
                'role_en' => 'Patron of the BREE Foundation',
                'description_fr' => "Mme Chantal BIYA, Première Dame du Cameroun et militante infatigable des droits humains, a accepté de parrainer la Fondation BREE en reconnaissance des valeurs communes qui nous unissent : la dignité, la solidarité et l'engagement au service des plus vulnérables.\n\nSon soutien apporte à notre action une légitimité institutionnelle précieuse et renforce notre capacité à mobiliser des partenaires à l'échelle internationale.",
                'description_en' => "Mrs. Chantal BIYA, First Lady of Cameroon and tireless human rights advocate, agreed to sponsor the BREE Foundation in recognition of the shared values that unite us: dignity, solidarity and commitment to serving the most vulnerable.\n\nHer support lends our work valuable institutional legitimacy and strengthens our ability to mobilise partners at the international level.",
                'quote_fr' => '« Aider ceux qui en ont besoin est pour moi un devoir de solidarité. »',
                'quote_en' => '"Helping those in need is for me a duty of solidarity."',
                'photo_path' => null,
                'is_active' => true,
            ]
        );
    }
}
