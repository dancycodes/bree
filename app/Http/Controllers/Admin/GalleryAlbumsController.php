<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryAlbumsController extends Controller
{
    private const COVER_MAX_KILOBYTES = 15360;

    private function normalizeBooleanValue(mixed $value): mixed
    {
        if (is_array($value)) {
            $lastValue = end($value);

            return $this->normalizeBooleanValue($lastValue);
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value === 1;
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            $parsed = filter_var($trimmed, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($parsed !== null) {
                return $parsed;
            }
        }

        return $value;
    }

    private function normalizePublishedFlag(array $data): array
    {
        if (! array_key_exists('is_published', $data)) {
            return $data;
        }

        $data['is_published'] = $this->normalizeBooleanValue($data['is_published']);

        return $data;
    }

    private function normalizeSlugField(array $data): array
    {
        if (! array_key_exists('slug', $data)) {
            return $data;
        }

        $slug = Str::slug((string) $data['slug']);
        $data['slug'] = $slug !== '' ? $slug : (string) $data['slug'];

        return $data;
    }

    private function shouldReturnInlineErrors(Request $request): bool
    {
        return $request->isGale()
            || $request->expectsJson()
            || $request->ajax()
            || strcasecmp((string) $request->header('X-Requested-With', ''), 'XMLHttpRequest') === 0;
    }

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

        $stateRules = [
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:gallery_albums,slug',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_published' => 'boolean',
        ];

        if ($request->isGale()) {
            $jsonState = $this->normalizeSlugField(
                $this->normalizePublishedFlag((array) $request->state())
            );
            if (is_array($jsonState) && $jsonState !== []) {
                $validator = Validator::make($jsonState, $stateRules);
                if ($validator->fails()) {
                    return gale()->messages($validator->errors()->toArray());
                }

                $validated = $validator->validated();
            } else {
                $multipartState = $request->input('state', []);
                if (is_string($multipartState) && $multipartState !== '') {
                    $decodedState = json_decode($multipartState, true);
                    $multipartState = is_array($decodedState) ? $decodedState : [];
                }

                if (is_array($multipartState)) {
                    $multipartState = $this->normalizeSlugField(
                        $this->normalizePublishedFlag(array_merge(
                            $request->except(['cover', 'state']),
                            $multipartState
                        ))
                    );
                }

                if (is_array($multipartState) && $multipartState !== []) {
                    $validator = Validator::make($multipartState, $stateRules);
                    if ($validator->fails()) {
                        return gale()->messages($validator->errors()->toArray());
                    }

                    $validated = $validator->validated();
                } else {
                    $request->merge($this->normalizeSlugField($this->normalizePublishedFlag($request->all())));
                    $validator = Validator::make($request->all(), $stateRules);
                    if ($validator->fails()) {
                        if ($this->shouldReturnInlineErrors($request)) {
                            return response()->json(['messages' => $validator->errors()->toArray()]);
                        }

                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $validated = $validator->validated();
                }
            }
        } else {
            $request->merge($this->normalizeSlugField($this->normalizePublishedFlag($request->all())));
            $validator = Validator::make($request->all(), $stateRules);
            if ($validator->fails()) {
                if ($this->shouldReturnInlineErrors($request)) {
                    return response()->json(['messages' => $validator->errors()->toArray()]);
                }

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validated = $validator->validated();
        }

        $coverValidator = Validator::make($request->all(), [
            'cover' => 'nullable|image|max:'.self::COVER_MAX_KILOBYTES,
        ]);

        if ($coverValidator->fails()) {
            if ($this->shouldReturnInlineErrors($request)) {
                if ($request->isGale()) {
                    return gale()->messages($coverValidator->errors()->toArray());
                }

                return response()->json(['messages' => $coverValidator->errors()->toArray()]);
            }

            if ($request->isGale()) {
                return gale()->messages($coverValidator->errors()->toArray());
            }

            return redirect()->back()->withErrors($coverValidator)->withInput();
        }

        $album = GalleryAlbum::create([
            'slug' => $validated['slug'],
            'title_fr' => strip_tags($validated['title_fr']),
            'title_en' => strip_tags($validated['title_en']),
            'description_fr' => $validated['description_fr'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'is_published' => (bool) ($validated['is_published'] ?? false),
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

        $stateRules = [
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:gallery_albums,slug,'.$album->id,
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_published' => 'boolean',
        ];

        if ($request->isGale()) {
            $jsonState = $this->normalizeSlugField(
                $this->normalizePublishedFlag((array) $request->state())
            );

            if (is_array($jsonState) && $jsonState !== []) {
                $validator = Validator::make($jsonState, $stateRules);
                if ($validator->fails()) {
                    return gale()->messages($validator->errors()->toArray());
                }

                $validated = $validator->validated();
            } else {
                $multipartState = $request->input('state', []);
                if (is_string($multipartState) && $multipartState !== '') {
                    $decodedState = json_decode($multipartState, true);
                    $multipartState = is_array($decodedState) ? $decodedState : [];
                }

                if (is_array($multipartState)) {
                    $multipartState = $this->normalizeSlugField(
                        $this->normalizePublishedFlag(array_merge(
                            $request->except(['cover', 'state']),
                            $multipartState
                        ))
                    );
                }

                if (is_array($multipartState) && $multipartState !== []) {
                    $validator = Validator::make($multipartState, $stateRules);
                    if ($validator->fails()) {
                        return gale()->messages($validator->errors()->toArray());
                    }

                    $validated = $validator->validated();
                } else {
                    $request->merge($this->normalizeSlugField($this->normalizePublishedFlag($request->all())));
                    $validator = Validator::make($request->all(), $stateRules);
                    if ($validator->fails()) {
                        if ($this->shouldReturnInlineErrors($request)) {
                            return response()->json(['messages' => $validator->errors()->toArray()]);
                        }

                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $validated = $validator->validated();
                }
            }
        } else {
            $request->merge($this->normalizeSlugField($this->normalizePublishedFlag($request->all())));
            $validator = Validator::make($request->all(), $stateRules);
            if ($validator->fails()) {
                if ($this->shouldReturnInlineErrors($request)) {
                    return response()->json(['messages' => $validator->errors()->toArray()]);
                }

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validated = $validator->validated();
        }

        $coverValidator = Validator::make($request->all(), [
            'cover' => 'nullable|image|max:'.self::COVER_MAX_KILOBYTES,
        ]);

        if ($coverValidator->fails()) {
            if ($this->shouldReturnInlineErrors($request)) {
                if ($request->isGale()) {
                    return gale()->messages($coverValidator->errors()->toArray());
                }

                return response()->json(['messages' => $coverValidator->errors()->toArray()]);
            }

            if ($request->isGale()) {
                return gale()->messages($coverValidator->errors()->toArray());
            }

            return redirect()->back()->withErrors($coverValidator)->withInput();
        }

        $coverPath = $album->cover_photo_path;
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('gallery/covers', 'public');
            $coverPath = 'storage/'.$path;
        }

        $album->update([
            'slug' => $validated['slug'],
            'title_fr' => strip_tags($validated['title_fr']),
            'title_en' => strip_tags($validated['title_en']),
            'description_fr' => $validated['description_fr'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'is_published' => (bool) ($validated['is_published'] ?? false),
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
