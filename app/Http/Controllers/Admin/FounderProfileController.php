<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FounderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'is_active' => true,
            ]
        );

        return gale()->dispatch('toast', ['message' => 'Profil fondatrice mis à jour', 'type' => 'success']);
    }

    public function uploadPhoto(Request $request): mixed
    {
        $this->authorize('about.edit');

        $request->validate(['photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120']);

        $founder = FounderProfile::where('is_active', true)->firstOrFail();

        if ($founder->photo_path && str_starts_with($founder->photo_path, 'storage/')) {
            $old = str_replace('storage/', '', $founder->photo_path);
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        $path = $request->file('photo')->store('profiles/founder', 'public');
        $founder->update(['photo_path' => 'storage/'.$path]);

        return gale()->redirect(route('admin.about.founder.edit'));
    }
}
