<?php

use App\Models\GalleryAlbum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

it('rejects gallery photo uploads larger than 20MB', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    Permission::findOrCreate('gallery.create');
    $admin->givePermissionTo('gallery.create');

    $album = GalleryAlbum::query()->create([
        'slug' => 'album-photos-20mb',
        'title_fr' => 'Album 20 MB',
        'title_en' => 'Album 20 MB',
        'is_published' => true,
    ]);

    $photo = UploadedFile::fake()->image('photo-too-large.jpg')->size(21000);

    $this->actingAs($admin)
        ->post(route('admin.gallery.albums.photos.store', $album), [
            'photo' => $photo,
        ])
        ->assertSessionHasErrors('photo');
});
