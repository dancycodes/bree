<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatronProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatronProfileController extends Controller
{
    public function edit(): mixed
    {
        $this->authorize('about.edit');

        $patron = PatronProfile::active() ?? new PatronProfile;

        return gale()->view('admin.about.patron', compact('patron'), web: true);
    }

    public function update(Request $request): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'name' => 'required|string|max:150',
            'title_fr' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'role_fr' => 'required|string|max:200',
            'role_en' => 'required|string|max:200',
            'description_fr' => 'nullable|string|max:3000',
            'description_en' => 'nullable|string|max:3000',
            'quote_fr' => 'nullable|string|max:300',
            'quote_en' => 'nullable|string|max:300',
        ]);

        PatronProfile::updateOrCreate(
            ['is_active' => true],
            [
                'name' => strip_tags($validated['name']),
                'title_fr' => strip_tags($validated['title_fr']),
                'title_en' => strip_tags($validated['title_en']),
                'role_fr' => strip_tags($validated['role_fr']),
                'role_en' => strip_tags($validated['role_en']),
                'description_fr' => isset($validated['description_fr']) ? strip_tags($validated['description_fr']) : null,
                'description_en' => isset($validated['description_en']) ? strip_tags($validated['description_en']) : null,
                'quote_fr' => isset($validated['quote_fr']) ? strip_tags($validated['quote_fr']) : null,
                'quote_en' => isset($validated['quote_en']) ? strip_tags($validated['quote_en']) : null,
                'is_active' => true,
            ]
        );

        return gale()->dispatch('toast', ['message' => 'Profil marraine mis à jour', 'type' => 'success']);
    }

    public function uploadPhoto(Request $request): mixed
    {
        $this->authorize('about.edit');

        $request->validate(['photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120']);

        $patron = PatronProfile::where('is_active', true)->firstOrFail();

        if ($patron->photo_path && str_starts_with($patron->photo_path, 'storage/')) {
            $old = str_replace('storage/', '', $patron->photo_path);
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        $path = $request->file('photo')->store('profiles/patron', 'public');
        $patron->update(['photo_path' => 'storage/'.$path]);

        return gale()->redirect(route('admin.about.patron.edit'));
    }
}
