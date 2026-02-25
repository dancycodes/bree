<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class AdminTeamMembersController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('about.edit');

        $members = TeamMember::orderBy('sort_order')->get();

        return gale()->view('admin.about.team', compact('members'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'name' => 'required|string|max:150',
            'title_fr' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'is_published' => 'boolean',
        ]);

        $maxOrder = TeamMember::max('sort_order') ?? 0;

        TeamMember::create([
            'name' => strip_tags($validated['name']),
            'title_fr' => strip_tags($validated['title_fr']),
            'title_en' => strip_tags($validated['title_en']),
            'is_published' => $validated['is_published'] ?? false,
            'sort_order' => $maxOrder + 1,
        ]);

        $members = TeamMember::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.about.team', 'team-list', compact('members'))
            ->state('name', '')
            ->state('title_fr', '')
            ->state('title_en', '')
            ->state('is_published', false)
            ->dispatch('toast', ['message' => 'Membre ajouté', 'type' => 'success']);
    }

    public function edit(TeamMember $member): mixed
    {
        $this->authorize('about.edit');

        return gale()->view('admin.about.team-edit', compact('member'), web: true);
    }

    public function update(Request $request, TeamMember $member): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'name' => 'required|string|max:150',
            'title_fr' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'bio_fr' => 'nullable|string|max:2000',
            'bio_en' => 'nullable|string|max:2000',
            'photo_path' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $member->update([
            'name' => strip_tags($validated['name']),
            'title_fr' => strip_tags($validated['title_fr']),
            'title_en' => strip_tags($validated['title_en']),
            'bio_fr' => isset($validated['bio_fr']) ? strip_tags($validated['bio_fr']) : null,
            'bio_en' => isset($validated['bio_en']) ? strip_tags($validated['bio_en']) : null,
            'photo_path' => $validated['photo_path'] ?? null,
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return gale()->dispatch('toast', ['message' => 'Membre mis à jour', 'type' => 'success']);
    }

    public function destroy(TeamMember $member): mixed
    {
        $this->authorize('about.edit');

        $member->delete();

        $members = TeamMember::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.about.team', 'team-list', compact('members'))
            ->dispatch('toast', ['message' => 'Membre supprimé', 'type' => 'success']);
    }

    public function reorder(Request $request): mixed
    {
        $this->authorize('about.edit');

        $ids = $request->state('members') ?? [];

        foreach ($ids as $order => $id) {
            TeamMember::where('id', $id)->update(['sort_order' => $order + 1]);
        }

        return gale()->dispatch('toast', ['message' => 'Ordre mis à jour', 'type' => 'success']);
    }

    public function togglePublished(TeamMember $member): mixed
    {
        $this->authorize('about.edit');

        $member->update(['is_published' => ! $member->is_published]);

        $members = TeamMember::orderBy('sort_order')->get();

        return gale()->fragment('admin.about.team', 'team-list', compact('members'));
    }
}
