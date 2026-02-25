<?php

namespace Database\Seeders;

use App\Models\MissionSection;
use Illuminate\Database\Seeder;

class MissionSectionSeeder extends Seeder
{
    // Heroicons outline paths for mission icons
    private const SHIELD = 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z';

    private const BOOK = 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25';

    private const LEAF = 'M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643';

    private const USERS = 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z';

    private const LINK = 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244';

    public function run(): void
    {
        MissionSection::firstOrCreate(
            ['id' => 1],
            [
                'vision_fr' => 'Notre vision est un monde où chaque femme et chaque enfant peut s\'épanouir, se former et vivre dignement, dans un environnement sain et sécurisé.',
                'vision_en' => 'Our vision is a world where every woman and every child can thrive, learn, and live with dignity in a healthy and safe environment.',
                'mission_1_fr' => 'Protéger les droits des femmes et des enfants vulnérables',
                'mission_1_en' => 'Protect the rights of vulnerable women and children',
                'mission_1_icon' => self::SHIELD,
                'mission_2_fr' => 'Favoriser l\'accès à l\'éducation pour tous',
                'mission_2_en' => 'Foster access to education for all',
                'mission_2_icon' => self::BOOK,
                'mission_3_fr' => 'Promouvoir la santé et l\'environnement durable',
                'mission_3_en' => 'Promote health and a sustainable environment',
                'mission_3_icon' => self::LEAF,
                'mission_4_fr' => 'Renforcer les capacités des communautés locales',
                'mission_4_en' => 'Strengthen the capacities of local communities',
                'mission_4_icon' => self::USERS,
                'mission_5_fr' => 'Créer des partenariats pour un impact durable',
                'mission_5_en' => 'Build partnerships for lasting impact',
                'mission_5_icon' => self::LINK,
                'is_active' => true,
            ]
        );
    }
}
