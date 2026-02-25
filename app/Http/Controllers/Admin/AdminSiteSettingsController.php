<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminSiteSettingsController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('settings.manage');

        $settings = SiteSetting::allSettings();

        return gale()->view('admin.settings.index', compact('settings'), web: true);
    }

    public function update(Request $request): mixed
    {
        $this->authorize('settings.manage');

        $validated = $request->validateState([
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'social_facebook' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
            'social_linkedin' => 'nullable|url|max:500',
            'social_youtube' => 'nullable|url|max:500',
            'social_twitter' => 'nullable|url|max:500',
            'donation_show_total' => 'nullable|in:0,1',
            'donation_amounts' => 'nullable|string|max:500',
        ]);

        SiteSetting::setMany(array_map(fn ($v) => $v ?? '', $validated));

        activity('admin')->causedBy(auth()->user())->log('Paramètres du site mis à jour');

        return gale()->dispatch('toast', ['message' => 'Paramètres enregistrés', 'type' => 'success']);
    }
}
