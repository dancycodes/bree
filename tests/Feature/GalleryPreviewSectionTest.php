<?php

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('homepage renders gallery section with published photos', function () {
    $album = GalleryAlbum::create([
        'slug' => 'test-album',
        'title_fr' => 'Album Test',
        'title_en' => 'Test Album',
        'is_published' => true,
    ]);

    GalleryPhoto::create([
        'album_id' => $album->id,
        'path' => 'images/sections/gallery-placeholder.jpg',
        'caption_fr' => 'Photo test FR',
        'caption_en' => 'Test photo EN',
        'sort_order' => 1,
    ]);

    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertSee('Nos Activités en Images')
        ->assertSee('Voir toute la galerie')
        ->assertSee('gallery-placeholder.jpg');
});

it('homepage shows gallery empty state when no published photos', function () {
    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertSee('Aucune photo disponible pour le moment');
});

it('homepage does not show photos from unpublished albums', function () {
    $album = GalleryAlbum::create([
        'slug' => 'private-album',
        'title_fr' => 'Album Privé',
        'title_en' => 'Private Album',
        'is_published' => false,
    ]);

    GalleryPhoto::create([
        'album_id' => $album->id,
        'path' => 'images/sections/gallery-placeholder.jpg',
        'caption_fr' => 'Photo privée',
        'caption_en' => 'Private photo',
        'sort_order' => 1,
    ]);

    $this->get(route('public.home'))
        ->assertSuccessful()
        ->assertSee('Aucune photo disponible pour le moment');
});

it('homepage shows at most 8 photos in gallery preview', function () {
    $album = GalleryAlbum::create([
        'slug' => 'big-album',
        'title_fr' => 'Grand Album',
        'title_en' => 'Big Album',
        'is_published' => true,
    ]);

    foreach (range(1, 10) as $i) {
        GalleryPhoto::create([
            'album_id' => $album->id,
            'path' => "images/sections/photo-{$i}.jpg",
            'caption_fr' => "Photo {$i}",
            'caption_en' => "Photo {$i}",
            'sort_order' => $i,
        ]);
    }

    $response = $this->get(route('public.home'));
    $response->assertSuccessful();

    // Only 8 of the 10 photos should appear in the page source
    $content = $response->getContent();
    $count = substr_count($content, 'images/sections/photo-');
    expect($count)->toBe(8);
});
