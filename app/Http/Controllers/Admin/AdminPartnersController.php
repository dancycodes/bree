<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPartnersController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('partners.view');

        $partners = Partner::orderBy('sort_order')->orderBy('name')->get();

        return gale()->view('admin.partners.index', compact('partners'), web: true);
    }

    public function create(): mixed
    {
        $this->authorize('partners.create');

        return gale()->view('admin.partners.create', [], web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('partners.create');

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:institutional,financial,technical',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
        ]);

        $maxSort = Partner::max('sort_order') ?? 0;

        $partner = Partner::create([
            'name' => strip_tags($request->input('name')),
            'type' => $request->input('type'),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'website_url' => $request->input('website_url'),
            'is_published' => (bool) $request->input('is_published', false),
            'sort_order' => $maxSort + 1,
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners/logos', 'public');
            $partner->update(['logo_path' => 'storage/'.$path]);
        }

        return gale()->redirect(route('admin.partners.edit', $partner));
    }

    public function edit(Partner $partner): mixed
    {
        $this->authorize('partners.edit');

        return gale()->view('admin.partners.edit', compact('partner'), web: true);
    }

    public function update(Request $request, Partner $partner): mixed
    {
        $this->authorize('partners.edit');

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:institutional,financial,technical',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
        ]);

        $logoPath = $partner->logo_path;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners/logos', 'public');
            $logoPath = 'storage/'.$path;
        }

        if ($request->input('remove_logo') === '1' && $partner->logo_path) {
            $storagePath = str_replace('storage/', '', $partner->logo_path);
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
            $logoPath = null;
        }

        $partner->update([
            'name' => strip_tags($request->input('name')),
            'type' => $request->input('type'),
            'description_fr' => $request->input('description_fr'),
            'description_en' => $request->input('description_en'),
            'website_url' => $request->input('website_url'),
            'is_published' => (bool) $request->input('is_published', false),
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('admin.partners.edit', $partner)->with('success', 'Partenaire sauvegardé');
    }

    public function destroy(Request $request, Partner $partner): mixed
    {
        $this->authorize('partners.delete');

        $partnerId = $partner->id;

        if ($partner->logo_path && str_starts_with($partner->logo_path, 'storage/')) {
            $storagePath = str_replace('storage/', '', $partner->logo_path);
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
        }

        $partner->delete();

        if ($request->isGale()) {
            $partners = Partner::orderBy('sort_order')->orderBy('name')->get();

            return gale()
                ->fragment('admin.partners.index', 'partners-table', compact('partners'))
                ->dispatch('toast', ['message' => 'Partenaire supprimé', 'type' => 'success']);
        }

        return redirect()->route('admin.partners.index')->with('success', 'Partenaire supprimé');
    }

    public function reorder(Request $request): JsonResponse
    {
        $this->authorize('partners.edit');

        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:partners,id']);

        foreach ($request->input('order') as $position => $id) {
            Partner::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['ok' => true]);
    }
}
