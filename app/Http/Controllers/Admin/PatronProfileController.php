<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatronProfile;
use Illuminate\Http\Request;

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
            'photo_path' => 'nullable|string|max:255',
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
                'photo_path' => $validated['photo_path'] ?? null,
                'is_active' => true,
            ]
        );

        return gale()->dispatch('toast', ['message' => 'Profil marraine mis à jour', 'type' => 'success']);
    }
}
