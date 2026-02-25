<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    public function index(): mixed
    {
        $albums = GalleryAlbum::published()->withCount('photos')->paginate(12);

        return gale()->view('public.gallery.index', compact('albums'), web: true);
    }

    public function show(GalleryAlbum $album): mixed
    {
        if (! $album->is_published) {
            abort(404);
        }

        $photos = $album->photos()->get();

        return gale()->view('public.gallery.show', compact('album', 'photos'), web: true);
    }
}
