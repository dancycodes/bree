<?php

use App\Models\GalleryAlbum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

it('stores a gallery album cover image from admin create flow', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $cover = UploadedFile::fake()->image('cover.jpg', 800, 800);

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.store'), [
            'title_fr' => 'Album test',
            'title_en' => 'Test album',
            'slug' => 'album-test',
            'description_fr' => 'Description FR',
            'description_en' => 'Description EN',
            'is_published' => '1',
            'cover' => $cover,
        ])
        ->assertRedirect();

    $album = GalleryAlbum::query()->where('slug', 'album-test')->first();

    expect($album)->not->toBeNull();
    expect($album->cover_photo_path)->not->toBeNull();

    Storage::disk('public')->assertExists(str_replace('storage/', '', $album->cover_photo_path));
});

it('stores a gallery album cover image from gale request payload', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $cover = UploadedFile::fake()->image('cover-gale.jpg', 600, 600);

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.store'), [
            'title_fr' => 'Album gale',
            'title_en' => 'Gale album',
            'slug' => 'album-gale',
            'description_fr' => 'Description FR gale',
            'description_en' => 'Description EN gale',
            'is_published' => true,
            'cover' => $cover,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $album = GalleryAlbum::query()->where('slug', 'album-gale')->first();

    expect($album)->not->toBeNull();
    expect($album->cover_photo_path)->not->toBeNull();

    Storage::disk('public')->assertExists(str_replace('storage/', '', $album->cover_photo_path));
});

it('stores a gallery album cover image from gale multipart state payload', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $cover = UploadedFile::fake()->image('cover-gale-multipart.jpg', 600, 600);

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.store'), [
            'state' => [
                'title_fr' => 'Album gale multipart',
                'title_en' => 'Gale multipart album',
                'slug' => 'album-gale-multipart',
                'description_fr' => 'Description FR gale multipart',
                'description_en' => 'Description EN gale multipart',
                'is_published' => true,
            ],
            'cover' => $cover,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $album = GalleryAlbum::query()->where('slug', 'album-gale-multipart')->first();

    expect($album)->not->toBeNull();
    expect($album->cover_photo_path)->not->toBeNull();

    Storage::disk('public')->assertExists(str_replace('storage/', '', $album->cover_photo_path));
});

it('accepts gale is_published as string true', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $cover = UploadedFile::fake()->image('cover-gale-string-bool.jpg', 600, 600);

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.store'), [
            'state' => [
                'title_fr' => 'Album bool string',
                'title_en' => 'Album bool string',
                'slug' => 'album-bool-string',
                'description_fr' => 'Description FR',
                'description_en' => 'Description EN',
                'is_published' => 'true',
            ],
            'cover' => $cover,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $album = GalleryAlbum::query()->where('slug', 'album-bool-string')->first();

    expect($album)->not->toBeNull();
    expect($album->is_published)->toBeTrue();
});

it('normalizes slug before storing album', function () {
    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.store'), [
            'title_fr' => 'Album test',
            'title_en' => 'Test album',
            'slug' => 'Mon Slug À Tester',
            'description_fr' => 'Description FR',
            'description_en' => 'Description EN',
            'is_published' => '1',
        ])
        ->assertRedirect();

    $album = GalleryAlbum::query()->where('slug', 'mon-slug-a-tester')->first();

    expect($album)->not->toBeNull();
});

it('updates album with cover image from gale multipart payload', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.edit');
    $admin->givePermissionTo('gallery.edit');

    $album = GalleryAlbum::query()->create([
        'slug' => 'album-edit-test',
        'title_fr' => 'Titre FR',
        'title_en' => 'Title EN',
        'description_fr' => 'Desc FR',
        'description_en' => 'Desc EN',
        'is_published' => false,
    ]);

    $cover = UploadedFile::fake()->image('cover-edit.jpg', 900, 900)->size(2048);

    $response = $this->actingAs($admin)
        ->patch(route('admin.gallery.albums.update', $album), [
            'state' => [
                'title_fr' => 'Titre FR modifie',
                'title_en' => 'Title EN updated',
                'slug' => 'album-edit-test',
                'description_fr' => 'Desc FR modifiee',
                'description_en' => 'Desc EN updated',
                'is_published' => 'true',
            ],
            'cover' => $cover,
        ], ['Gale-Request' => '1']);

    expect($response->getStatusCode())->toBe(200, $response->getContent());

    $album->refresh();

    expect($album->title_fr)->toBe('Titre FR modifie');
    expect($album->is_published)->toBeTrue();
    expect($album->cover_photo_path)->not->toBeNull();
    Storage::disk('public')->assertExists(str_replace('storage/', '', $album->cover_photo_path));
});
