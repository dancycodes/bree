<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramActivity;
use App\Models\ProgramCard;
use Illuminate\Http\Request;

class ProgramActivitiesController extends Controller
{
    public function index(ProgramCard $program): mixed
    {
        $this->authorize('programs.view');

        $activities = $program->programActivities()->orderBy('sort_order')->get();

        return gale()->view('admin.programs.activities', compact('program', 'activities'), web: true);
    }

    public function store(Request $request, ProgramCard $program): mixed
    {
        $this->authorize('programs.edit');

        $validated = $request->validateState([
            'name_fr' => 'required|string|max:200',
            'name_en' => 'required|string|max:200',
        ]);

        $maxOrder = $program->programActivities()->max('sort_order') ?? 0;

        $activity = $program->programActivities()->create([
            'name_fr' => $validated['name_fr'],
            'name_en' => $validated['name_en'],
            'sort_order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        $activities = $program->programActivities()->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.programs.activities', 'activities-list', compact('program', 'activities'))
            ->state('name_fr', '')
            ->state('name_en', '')
            ->dispatch('toast', ['message' => 'Activité ajoutée avec succès', 'type' => 'success']);
    }

    public function update(Request $request, ProgramActivity $activity): mixed
    {
        $this->authorize('programs.edit');

        $validated = $request->validateState([
            'editNameFr' => 'required|string|max:200',
            'editNameEn' => 'required|string|max:200',
        ]);

        $activity->update([
            'name_fr' => $validated['editNameFr'],
            'name_en' => $validated['editNameEn'],
        ]);

        $program = $activity->programCard;
        $activities = $program->programActivities()->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.programs.activities', 'activities-list', compact('program', 'activities'))
            ->state('editingId', null)
            ->dispatch('toast', ['message' => 'Activité mise à jour', 'type' => 'success']);
    }

    public function destroy(ProgramActivity $activity): mixed
    {
        $this->authorize('programs.edit');

        $program = $activity->programCard;
        $activity->delete();

        $activities = $program->programActivities()->orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.programs.activities', 'activities-list', compact('program', 'activities'))
            ->dispatch('toast', ['message' => 'Activité supprimée', 'type' => 'success']);
    }

    public function reorder(Request $request, ProgramCard $program): mixed
    {
        $this->authorize('programs.edit');

        $ids = $request->input('activities', []);

        foreach ($ids as $index => $id) {
            ProgramActivity::where('id', $id)
                ->where('program_card_id', $program->id)
                ->update(['sort_order' => $index + 1]);
        }

        return gale()->dispatch('toast', ['message' => 'Ordre mis à jour', 'type' => 'success']);
    }
}
