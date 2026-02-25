<?php

use App\Models\FounderProfile;
use App\Models\PatronProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('home page returns 200 and contains founder name from FounderProfile', function () {
    FounderProfile::create([
        'name' => 'Anastasie Brenda BIYA',
        'title_fr' => 'Présidente Fondatrice',
        'title_en' => 'Founding President',
        'bio_fr' => 'Biographie de la fondatrice.',
        'bio_en' => 'Founder biography.',
        'message_fr' => 'Notre engagement est total.',
        'message_en' => 'Our commitment is total.',
        'is_active' => true,
    ]);

    $this->get('/')
        ->assertStatus(200)
        ->assertSee('Anastasie Brenda BIYA');
});

it('home page returns 200 and contains patron name from PatronProfile', function () {
    PatronProfile::create([
        'name' => 'Chantal BIYA',
        'title_fr' => 'Première Dame du Cameroun',
        'title_en' => 'First Lady of Cameroon',
        'role_fr' => 'Marraine',
        'role_en' => 'Patron',
        'description_fr' => 'Description de la marraine.',
        'description_en' => 'Patron description.',
        'quote_fr' => 'Aider ceux qui en ont besoin.',
        'quote_en' => 'Helping those in need.',
        'is_active' => true,
    ]);

    $this->get('/')
        ->assertStatus(200)
        ->assertSee('Chantal BIYA');
});

it('about page returns 200 and contains founder name from FounderProfile', function () {
    FounderProfile::create([
        'name' => 'Anastasie Brenda BIYA',
        'title_fr' => 'Présidente Fondatrice',
        'title_en' => 'Founding President',
        'bio_fr' => 'Biographie de la fondatrice.',
        'bio_en' => 'Founder biography.',
        'is_active' => true,
    ]);

    $this->get('/a-propos')
        ->assertStatus(200)
        ->assertSee('Anastasie Brenda BIYA');
});

it('founder_sections table no longer exists', function () {
    expect(Schema::hasTable('founder_sections'))->toBeFalse();
});

it('FounderSection model file does not exist on disk', function () {
    expect(file_exists(app_path('Models/FounderSection.php')))->toBeFalse();
});
