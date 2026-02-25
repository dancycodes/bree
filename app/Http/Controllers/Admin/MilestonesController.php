<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundationMilestone;
use Illuminate\Http\Request;

class MilestonesController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('about.edit');

        $milestones = FoundationMilestone::orderBy('year')->orderBy('sort_order')->get();

        return gale()->view('admin.about.milestones', compact('milestones'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'year' => 'required|integer|min:1900|max:2100',
            'title_fr' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'description_fr' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
        ]);

        $maxOrder = FoundationMilestone::where('year', $validated['year'])->max('sort_order') ?? 0;

        FoundationMilestone::create([
            'year' => $validated['year'],
            'title_fr' => strip_tags($validated['title_fr']),
            'title_en' => strip_tags($validated['title_en']),
            'description_fr' => isset($validated['description_fr']) ? strip_tags($validated['description_fr']) : null,
            'description_en' => isset($validated['description_en']) ? strip_tags($validated['description_en']) : null,
            'sort_order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        $milestones = FoundationMilestone::orderBy('year')->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.about.milestones', 'milestones-list', compact('milestones'))
            ->state('year', '')
            ->state('title_fr', '')
            ->state('title_en', '')
            ->state('description_fr', '')
            ->state('description_en', '')
            ->dispatch('toast', ['message' => 'Étape ajoutée', 'type' => 'success']);
    }

    public function update(Request $request, FoundationMilestone $milestone): mixed
    {
        $this->authorize('about.edit');

        $validated = $request->validateState([
            'editYear' => 'required|integer|min:1900|max:2100',
            'editTitleFr' => 'required|string|max:200',
            'editTitleEn' => 'required|string|max:200',
            'editDescFr' => 'nullable|string|max:1000',
            'editDescEn' => 'nullable|string|max:1000',
        ]);

        $milestone->update([
            'year' => $validated['editYear'],
            'title_fr' => strip_tags($validated['editTitleFr']),
            'title_en' => strip_tags($validated['editTitleEn']),
            'description_fr' => isset($validated['editDescFr']) ? strip_tags($validated['editDescFr']) : null,
            'description_en' => isset($validated['editDescEn']) ? strip_tags($validated['editDescEn']) : null,
        ]);

        $milestones = FoundationMilestone::orderBy('year')->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.about.milestones', 'milestones-list', compact('milestones'))
            ->state('editingId', null)
            ->dispatch('toast', ['message' => 'Étape mise à jour', 'type' => 'success']);
    }

    public function destroy(FoundationMilestone $milestone): mixed
    {
        $this->authorize('about.edit');

        $milestone->delete();

        $milestones = FoundationMilestone::orderBy('year')->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.about.milestones', 'milestones-list', compact('milestones'))
            ->dispatch('toast', ['message' => 'Étape supprimée', 'type' => 'success']);
    }
}
