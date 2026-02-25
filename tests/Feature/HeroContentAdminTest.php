<?php

use App\Models\DonationCtaSection;
use App\Models\HeroSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    Permission::findOrCreate('content.edit');
    $this->admin->givePermissionTo('content.edit');
});

it('admin can view the hero content page', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.hero.index'))
        ->assertSuccessful();
});

it('unauthenticated user is redirected from hero page', function () {
    $this->get(route('admin.hero.index'))
        ->assertRedirect('/admin/login');
});

it('unauthorized user cannot access hero page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.hero.index'))
        ->assertForbidden();
});

it('admin can update the hero section', function () {
    HeroSection::create([
        'is_active' => true,
        'tagline_fr' => 'Old tagline',
        'tagline_en' => 'Old tagline EN',
        'subtitle_fr' => 'Old subtitle',
        'subtitle_en' => 'Old subtitle EN',
        'cta1_label_fr' => 'Old CTA1',
        'cta1_label_en' => 'Old CTA1 EN',
        'cta1_url' => '/old',
        'cta2_label_fr' => 'Old CTA2',
        'cta2_label_en' => 'Old CTA2 EN',
        'cta2_url' => '/old2',
        'bg_image_path' => 'images/sections/old.jpg',
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.hero.update'), [
            'tagline_fr' => 'Protéger. Élever. Inspirer.',
            'tagline_en' => 'Protect. Elevate. Inspire.',
            'subtitle_fr' => 'La Fondation BREE œuvre pour la protection des femmes.',
            'subtitle_en' => 'The BREE Foundation works for the protection of women.',
            'cta1_label_fr' => 'Découvrir nos programmes',
            'cta1_label_en' => 'Discover our programmes',
            'cta1_url' => '/programmes',
            'cta2_label_fr' => 'Faire un Don',
            'cta2_label_en' => 'Make a Donation',
            'cta2_url' => '/don',
            'bg_image_path' => 'images/sections/hero.jpg',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('hero_sections', [
        'tagline_fr' => 'Protéger. Élever. Inspirer.',
        'tagline_en' => 'Protect. Elevate. Inspire.',
        'cta1_url' => '/programmes',
        'is_active' => true,
    ]);
});

it('admin can update the donation cta section', function () {
    DonationCtaSection::create([
        'is_active' => true,
        'headline_fr' => 'Old headline',
        'headline_en' => 'Old headline EN',
        'copy_fr' => 'Old copy',
        'copy_en' => 'Old copy EN',
        'bg_image_path' => 'images/sections/old.jpg',
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.hero.cta.update'), [
            'cta_headline_fr' => 'Votre Générosité Change des Vies',
            'cta_headline_en' => 'Your Generosity Changes Lives',
            'cta_copy_fr' => 'Chaque don permet à la Fondation BREE d\'agir.',
            'cta_copy_en' => 'Every donation enables Fondation BREE to act.',
            'cta_bg_path' => 'images/sections/donate.jpg',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('donation_cta_sections', [
        'headline_fr' => 'Votre Générosité Change des Vies',
        'headline_en' => 'Your Generosity Changes Lives',
        'is_active' => true,
    ]);
});

it('hero update requires all bilingual fields', function () {
    HeroSection::create([
        'is_active' => true,
        'tagline_fr' => 'Original tagline',
        'tagline_en' => 'Original tagline EN',
        'subtitle_fr' => 'Original subtitle',
        'subtitle_en' => 'Original subtitle EN',
        'cta1_label_fr' => 'CTA1',
        'cta1_label_en' => 'CTA1 EN',
        'cta1_url' => '/programmes',
        'cta2_label_fr' => 'CTA2',
        'cta2_label_en' => 'CTA2 EN',
        'cta2_url' => '/don',
        'bg_image_path' => 'images/sections/hero.jpg',
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.hero.update'), [
            'tagline_fr' => '',
            'tagline_en' => '',
            'subtitle_fr' => '',
            'subtitle_en' => '',
            'cta1_label_fr' => '',
            'cta1_label_en' => '',
            'cta1_url' => '',
            'cta2_label_fr' => '',
            'cta2_label_en' => '',
            'cta2_url' => '',
            'bg_image_path' => '',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('hero_sections', ['tagline_fr' => 'Original tagline']);
});
