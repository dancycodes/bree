<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryPhotosController extends Controller
{
    public function index(GalleryAlbum $album): mixed
    {
        $this->authorize('gallery.view');

        $photos = $album->photos()->get();

        $photoData = $photos->map(fn (GalleryPhoto $p) => [
            'id' => $p->id,
            'url' => asset($p->path),
            'caption_fr' => $p->caption_fr,
            'caption_en' => $p->caption_en,
            'sort_order' => $p->sort_order,
            'update_url' => route('admin.gallery.albums.photos.updateCaption', $p),
            'delete_url' => route('admin.gallery.albums.photos.destroy', $p),
        ])->values()->toArray();

        return gale()->view('admin.gallery.photos.index', compact('album', 'photoData'), web: true);
    }

    public function store(Request $request, GalleryAlbum $album): JsonResponse
    {
        $this->authorize('gallery.create');

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $file = $request->file('photo');
        $path = $file->store('gallery/photos/'.$album->id, 'public');

        // Resize via Intervention Image (max 1920px) to reduce storage footprint
        $fullPath = storage_path('app/public/'.$path);
        (new ImageManager(new Driver))->read($fullPath)->scaleDown(width: 1920, height: 1920)->save($fullPath);

        $maxSort = GalleryPhoto::where('album_id', $album->id)->max('sort_order') ?? 0;

        $photo = GalleryPhoto::create([
            'album_id' => $album->id,
            'path' => 'storage/'.$path,
            'sort_order' => $maxSort + 1,
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => asset($photo->path),
            'sort_order' => $photo->sort_order,
            'caption_fr' => null,
            'caption_en' => null,
            'update_url' => route('admin.gallery.albums.photos.updateCaption', $photo),
            'delete_url' => route('admin.gallery.albums.photos.destroy', $photo),
        ]);
    }

    public function updateCaption(Request $request, GalleryPhoto $photo): JsonResponse
    {
        $this->authorize('gallery.edit');

        $request->validate([
            'caption_fr' => 'nullable|string|max:500',
            'caption_en' => 'nullable|string|max:500',
        ]);

        $photo->update([
            'caption_fr' => $request->input('caption_fr') ?: null,
            'caption_en' => $request->input('caption_en') ?: null,
        ]);

        return response()->json([
            'id' => $photo->id,
            'caption_fr' => $photo->caption_fr,
            'caption_en' => $photo->caption_en,
        ]);
    }

    public function reorder(Request $request, GalleryAlbum $album): JsonResponse
    {
        $this->authorize('gallery.edit');

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:gallery_photos,id',
        ]);

        foreach ($request->input('order') as $index => $photoId) {
            GalleryPhoto::where('id', $photoId)
                ->where('album_id', $album->id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(GalleryPhoto $photo): mixed
    {
        $this->authorize('gallery.delete');

        $photoId = $photo->id;

        $storagePath = str_replace('storage/', '', $photo->path);
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }

        $photo->delete();

        return gale()
            ->remove('#photo-'.$photoId)
            ->dispatch('toast', ['message' => 'Photo supprimée', 'type' => 'success']);
    }
}
