<?php

namespace Database\Seeders;

use App\Models\FounderProfile;
use Illuminate\Database\Seeder;

class FounderProfileSeeder extends Seeder
{
    public function run(): void
    {
        FounderProfile::firstOrCreate(
            ['name' => 'Brenda BIYA'],
            [
                'title_fr' => 'Fondatrice & Présidente de la Fondation BREE',
                'title_en' => 'Founder & President of the BREE Foundation',
                'bio_fr' => "Brenda BIYA est une militante des droits humains et philanthrope engagée depuis plus d'une décennie dans la protection des femmes et des enfants vulnérables. Diplômée en droit international et en développement social, elle a consacré sa carrière à combler les lacunes systémiques qui perpétuent les inégalités.\n\nEn 2015, elle fonde la Fondation BREE avec une conviction simple mais puissante : chaque être humain mérite dignité, éducation et sécurité — indépendamment de son origine, de son genre ou de ses ressources. Sous sa direction, la fondation est devenue une voix influente sur la scène internationale, présente dans plus de 10 pays.",
                'bio_en' => "Brenda BIYA is a human rights activist and philanthropist who has been engaged for more than a decade in the protection of vulnerable women and children. Holding degrees in international law and social development, she has dedicated her career to closing the systemic gaps that perpetuate inequality.\n\nIn 2015, she founded the BREE Foundation with a simple but powerful conviction: every human being deserves dignity, education and security — regardless of their origin, gender or resources. Under her leadership, the foundation has become an influential voice on the international stage, present in more than 10 countries.",
                'message_fr' => "« Ce qui me motive chaque matin, ce ne sont pas les statistiques ni les rapports — ce sont les visages des femmes que nous avons aidées à se relever, et les sourires des enfants qui ont enfin accès à une école. C'est pour eux que nous continuons. »",
                'message_en' => '"What motivates me every morning is not statistics or reports — it is the faces of the women we have helped to rise, and the smiles of children who finally have access to a school. It is for them that we continue."',
                'photo_path' => null,
                'is_active' => true,
            ]
        );
    }
}
