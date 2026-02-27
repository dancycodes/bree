<?php

use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('about page renders without team members', function () {
    $this->get(route('public.about'))
        ->assertSuccessful();
});

it('team section is hidden when no published members', function () {
    TeamMember::create([
        'name' => 'Membre Brouillon',
        'title_fr' => 'Directrice',
        'title_en' => 'Director',
        'is_published' => false,
        'sort_order' => 1,
    ]);

    $this->get(route('public.about'))
        ->assertDontSee('Membre Brouillon');
});

it('team section shows published members', function () {
    SiteSetting::set('team_section_visible', '1');

    TeamMember::create([
        'name' => 'Amina Diallo',
        'title_fr' => 'Directrice Générale',
        'title_en' => 'Executive Director',
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('public.about'))
        ->assertSee('Amina Diallo')
        ->assertSee('Directrice Générale');
});

it('team section hidden when toggle is off even with published members', function () {
    // Default is '0' (hidden), so no need to set explicitly
    TeamMember::create([
        'name' => 'Hidden Member',
        'title_fr' => 'Directrice',
        'title_en' => 'Director',
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('public.about'))
        ->assertDontSee('Hidden Member');
});

it('unpublished team members do not appear', function () {
    SiteSetting::set('team_section_visible', '1');

    TeamMember::create([
        'name' => 'Visible',
        'title_fr' => 'Visible FR',
        'title_en' => 'Visible EN',
        'is_published' => true,
        'sort_order' => 1,
    ]);

    TeamMember::create([
        'name' => 'Masqué',
        'title_fr' => 'Masqué FR',
        'title_en' => 'Masqué EN',
        'is_published' => false,
        'sort_order' => 2,
    ]);

    $this->get(route('public.about'))
        ->assertSee('Visible')
        ->assertDontSee('Masqué');
});
