<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::setMany($this->settings());
    }

    /**
     * @return array<string, string>
     */
    private function settings(): array
    {
        return [
            'organization_name'       => 'Fondation BREE',
            'contact_email'           => 'contact@breefondation.org',
            'contact_phone'           => '+41 22 345 69 89',
            'contact_phone_cameroon'  => '+237 622 150 000',
            'website'                 => 'https://www.breefondation.org',
            'contact_address'         => 'Rue de Lausanne 42, 1201 Genève, Suisse',
            'social_facebook'         => 'https://www.facebook.com/fondationbree',
            'social_twitter'          => 'https://www.twitter.com/fondationbree',
            'social_instagram'        => 'https://www.instagram.com/fondationbree',
            'social_linkedin'         => 'https://www.linkedin.com/company/fondationbree',
            'social_youtube'          => 'https://www.youtube.com/@fondationbree',
            'donation_currency'       => 'CHF',
            'donation_currency_symbol' => 'CHF',
            'meta_title_fr'           => 'Fondation BREE — Protéger. Élever. Inspirer.',
            'meta_title_en'           => 'Fondation BREE — Protect. Elevate. Inspire.',
            'meta_description_fr'     => 'La Fondation BREE oeuvre pour la protection des femmes et enfants vulnérables au Cameroun et en Afrique.',
            'meta_description_en'     => 'Fondation BREE works to protect vulnerable women and children in Cameroon and across Africa.',
        ];
    }
}
