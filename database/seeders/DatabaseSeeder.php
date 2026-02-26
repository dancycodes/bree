<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@breefondation.org'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('Admin@Bree2025!'),
            ]
        );

        $this->call(PermissionSeeder::class);
        $this->call(SiteSettingsSeeder::class);
        $this->call(FounderProfileSeeder::class);
        $this->call(PatronProfileSeeder::class);
        $this->call(HeroSectionSeeder::class);
        $this->call(MissionSectionSeeder::class);
        $this->call(FoundationMilestoneSeeder::class);
        $this->call(ProgramCardSeeder::class);
        $this->call(TeamMemberSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(NewsCategorySeeder::class);
        $this->call(NewsArticleSeeder::class);
    }
}
