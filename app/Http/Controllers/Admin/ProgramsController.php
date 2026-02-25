<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCard;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('programs.view');

        $programs = ProgramCard::active()->withCount('programActivities')->get();

        return gale()->view('admin.programs.index', compact('programs'), web: true);
    }

    public function edit(ProgramCard $program): mixed
    {
        $this->authorize('programs.edit');

        return gale()->view('admin.programs.edit', compact('program'), web: true);
    }

    public function update(Request $request, ProgramCard $program): mixed
    {
        $this->authorize('programs.edit');

        $validated = $request->validateState([
            'name_fr' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'description_fr' => 'required|string|max:300',
            'description_en' => 'required|string|max:300',
            'long_description_fr' => 'nullable|string|max:2000',
            'long_description_en' => 'nullable|string|max:2000',
            'image_path' => 'required|string|max:255',
            'color' => 'required|string|size:7',
            'stats_fr' => 'nullable|array|max:6',
            'stats_en' => 'nullable|array|max:6',
            'stats_fr.*.number' => 'required|string|max:20',
            'stats_fr.*.label' => 'required|string|max:60',
            'stats_en.*.number' => 'nullable|string|max:20',
            'stats_en.*.label' => 'required|string|max:60',
        ]);

        // Stat numbers are language-agnostic — copy from stats_fr to stats_en
        $statsFr = array_map(fn ($s) => ['number' => strip_tags($s['number']), 'label' => strip_tags($s['label'])], $validated['stats_fr'] ?? []);
        $statsEn = array_map(fn ($s, $fr) => ['number' => $fr['number'], 'label' => strip_tags($s['label'])], $validated['stats_en'] ?? [], $statsFr);

        $program->update([
            'name_fr' => strip_tags($validated['name_fr']),
            'name_en' => strip_tags($validated['name_en']),
            'description_fr' => strip_tags($validated['description_fr']),
            'description_en' => strip_tags($validated['description_en']),
            'long_description_fr' => isset($validated['long_description_fr']) ? strip_tags($validated['long_description_fr']) : null,
            'long_description_en' => isset($validated['long_description_en']) ? strip_tags($validated['long_description_en']) : null,
            'image_path' => $validated['image_path'],
            'color' => $validated['color'],
            'stats_fr' => $statsFr,
            'stats_en' => $statsEn,
        ]);

        return gale()->dispatch('toast', ['message' => 'Programme mis à jour', 'type' => 'success']);
    }
}
