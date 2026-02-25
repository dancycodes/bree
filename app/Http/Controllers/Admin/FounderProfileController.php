<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FounderProfile;
use Illuminate\Http\Request;

class FounderProfileController extends Controller
{
    public function edit(): mixed
    {
        $this->authorize('about.edit');

        $founder = FounderProfile::active() ?? new FounderProfile;

        return gale()->view('admin.about.founder', compact('founder'), web: true);
    }

    public function update(Request $request): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'name' => 'required|string|max:150',
            'title_fr' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'bio_fr' => 'required|string|max:3000',
            'bio_en' => 'required|string|max:3000',
            'message_fr' => 'nullable|string|max:500',
            'message_en' => 'nullable|string|max:500',
            'photo_path' => 'nullable|string|max:255',
        ]);

        FounderProfile::updateOrCreate(
            ['is_active' => true],
            [
                'name' => strip_tags($validated['name']),
                'title_fr' => strip_tags($validated['title_fr']),
                'title_en' => strip_tags($validated['title_en']),
                'bio_fr' => strip_tags($validated['bio_fr']),
                'bio_en' => strip_tags($validated['bio_en']),
                'message_fr' => isset($validated['message_fr']) ? strip_tags($validated['message_fr']) : null,
                'message_en' => isset($validated['message_en']) ? strip_tags($validated['message_en']) : null,
                'photo_path' => $validated['photo_path'] ?? null,
                'is_active' => true,
            ]
        );

        return gale()->dispatch('toast', ['message' => 'Profil fondatrice mis à jour', 'type' => 'success']);
    }
}
