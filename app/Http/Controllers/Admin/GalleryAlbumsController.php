<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumsController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('gallery.view');

        $status = $request->input('status', 'all');
        $search = trim((string) $request->input('search', ''));

        $query = GalleryAlbum::withCount('photos')->orderByDesc('created_at');

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title_fr', 'ilike', "%{$search}%")
                    ->orWhere('title_en', 'ilike', "%{$search}%");
            });
        }

        $albums = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => GalleryAlbum::count(),
            'published' => GalleryAlbum::where('is_published', true)->count(),
            'draft' => GalleryAlbum::where('is_published', false)->count(),
        ];

        $data = compact('albums', 'status', 'search', 'counts');

        if ($request->isGaleNavigate('albums-table')) {
            return gale()->fragment('admin.gallery.albums.index', 'albums-table', $data);
        }

        return gale()->view('admin.gallery.albums.index', $data, web: true);
    }

    public function create(): mixed
    {
        $this->authorize('gallery.create');

        return gale()->view('admin.gallery.albums.create', [], web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('gallery.create');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:gallery_albums,slug',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_published' => 'boolean',
            'cover' => 'nullable|image|max:15360',
        ]);

        $album = GalleryAlbum::create([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'is_published' => (bool) $request->input('is_published', false),
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('gallery/covers', 'public');
            $album->update(['cover_photo_path' => 'storage/'.$path]);
        }

        return gale()->redirect(route('admin.gallery.albums.edit', $album));
    }

    public function edit(GalleryAlbum $album): mixed
    {
        $this->authorize('gallery.edit');

        return gale()->view('admin.gallery.albums.edit', compact('album'), web: true);
    }

    public function update(Request $request, GalleryAlbum $album): mixed
    {
        $this->authorize('gallery.edit');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:gallery_albums,slug,'.$album->id,
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_published' => 'boolean',
            'cover' => 'nullable|image|max:5120',
        ]);

        $coverPath = $album->cover_photo_path;
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('gallery/covers', 'public');
            $coverPath = 'storage/'.$path;
        }

        $album->update([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'is_published' => (bool) $request->input('is_published', false),
            'cover_photo_path' => $coverPath,
        ]);

        return gale()->dispatch('toast', ['message' => 'Album sauvegardé', 'type' => 'success']);
    }

    public function destroy(GalleryAlbum $album): mixed
    {
        $this->authorize('gallery.delete');

        // Delete photo files from storage before cascade DB delete
        foreach ($album->photos as $photo) {
            $storagePath = str_replace('storage/', '', $photo->path);
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
        }

        if ($album->cover_photo_path && str_starts_with($album->cover_photo_path, 'storage/')) {
            $coverPath = str_replace('storage/', '', $album->cover_photo_path);
            if (Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }
        }

        $album->delete();

        $status = 'all';
        $search = '';
        $albums = GalleryAlbum::withCount('photos')->orderByDesc('created_at')->paginate(20)->withQueryString();
        $counts = [
            'all' => GalleryAlbum::count(),
            'published' => GalleryAlbum::where('is_published', true)->count(),
            'draft' => GalleryAlbum::where('is_published', false)->count(),
        ];

        return gale()
            ->fragment('admin.gallery.albums.index', 'albums-table', compact('albums', 'status', 'search', 'counts'))
            ->dispatch('toast', ['message' => 'Album supprimé', 'type' => 'success']);
    }
}
