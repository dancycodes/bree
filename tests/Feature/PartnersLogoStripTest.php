<?php

use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('homepage shows partner names when partners are published', function () {
    Partner::factory()->create([
        'name' => 'UNICEF Cameroun',
        'is_published' => true,
        'website_url' => 'https://www.unicef.org/cameroon',
        'sort_order' => 1,
    ]);

    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertSee('Nos Partenaires')
        ->assertSee('UNICEF Cameroun');
});

it('homepage hides partner strip when no published partners', function () {
    Partner::factory()->create([
        'name' => 'Private Partner',
        'is_published' => false,
        'sort_order' => 1,
    ]);

    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertDontSee('Nos Partenaires');
});

it('partner with website url renders as a link', function () {
    Partner::factory()->create([
        'name' => 'ONU Femmes',
        'is_published' => true,
        'website_url' => 'https://www.unwomen.org',
        'sort_order' => 1,
    ]);

    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertSee('https://www.unwomen.org');
});

it('partner without website url renders name as text without its own link', function () {
    Partner::factory()->create([
        'name' => 'MinistereLocal-NoURL',
        'is_published' => true,
        'website_url' => null,
        'sort_order' => 1,
    ]);

    $response = $this->get(route('public.home'));
    $response->assertSuccessful()->assertSee('MinistereLocal-NoURL');

    // The partner should NOT have a link with its own URL since website_url is null
    expect($response->getContent())->not->toContain('href="MinistereLocal-NoURL"');
});
