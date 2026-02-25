<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatCounter;
use Illuminate\Http\Request;

class AdminStatCountersController extends Controller
{
    private const MAX_STATS = 8;

    public function index(): mixed
    {
        $this->authorize('stats.view');

        $stats = StatCounter::orderBy('sort_order')->get();

        return gale()->view('admin.stats.index', compact('stats'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('stats.edit');

        $stats = StatCounter::orderBy('sort_order')->get();

        if ($stats->count() >= self::MAX_STATS) {
            return gale()->dispatch('toast', ['message' => 'Maximum '.self::MAX_STATS.' statistiques autorisées', 'type' => 'error']);
        }

        $validated = $request->validateState([
            'number' => 'required|integer|min:0|max:9999999',
            'label_fr' => 'required|string|max:100',
            'label_en' => 'required|string|max:100',
            'icon_svg' => 'required|string|max:2000',
        ]);

        $maxOrder = StatCounter::max('sort_order') ?? 0;

        StatCounter::create([
            'number' => $validated['number'],
            'label_fr' => strip_tags($validated['label_fr']),
            'label_en' => strip_tags($validated['label_en']),
            'icon_svg' => $validated['icon_svg'],
            'sort_order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        $stats = StatCounter::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.stats.index', 'stats-list', compact('stats'))
            ->state('number', '')
            ->state('label_fr', '')
            ->state('label_en', '')
            ->state('icon_svg', '')
            ->dispatch('toast', ['message' => 'Statistique ajoutée', 'type' => 'success']);
    }

    public function update(Request $request, StatCounter $stat): mixed
    {
        $this->authorize('stats.edit');

        $validated = $request->validateState([
            'editNumber' => 'required|integer|min:0|max:9999999',
            'editLabelFr' => 'required|string|max:100',
            'editLabelEn' => 'required|string|max:100',
            'editIconSvg' => 'required|string|max:2000',
            'editActive' => 'nullable|in:0,1',
        ]);

        $stat->update([
            'number' => $validated['editNumber'],
            'label_fr' => strip_tags($validated['editLabelFr']),
            'label_en' => strip_tags($validated['editLabelEn']),
            'icon_svg' => $validated['editIconSvg'],
            'is_active' => ($validated['editActive'] ?? '1') === '1',
        ]);

        $stats = StatCounter::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.stats.index', 'stats-list', compact('stats'))
            ->state('editingId', null)
            ->dispatch('toast', ['message' => 'Statistique mise à jour', 'type' => 'success']);
    }

    public function destroy(StatCounter $stat): mixed
    {
        $this->authorize('stats.edit');

        $stat->delete();

        $stats = StatCounter::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.stats.index', 'stats-list', compact('stats'))
            ->dispatch('toast', ['message' => 'Statistique supprimée', 'type' => 'success']);
    }

    public function reorder(Request $request): mixed
    {
        $this->authorize('stats.edit');

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:stat_counters,id',
        ]);

        foreach ($validated['order'] as $position => $id) {
            StatCounter::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        $stats = StatCounter::orderBy('sort_order')->get();

        return gale()
            ->fragment('admin.stats.index', 'stats-list', compact('stats'))
            ->dispatch('toast', ['message' => 'Ordre mis à jour', 'type' => 'success']);
    }
}
