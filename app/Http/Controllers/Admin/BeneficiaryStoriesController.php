<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeneficiaryStory;
use App\Models\ProgramCard;
use Illuminate\Http\Request;

class BeneficiaryStoriesController extends Controller
{
    public function index(ProgramCard $program): mixed
    {
        $this->authorize('programs.view');

        $stories = $program->stories()->get();

        return gale()->view('admin.programs.stories', compact('program', 'stories'), web: true);
    }

    public function store(Request $request, ProgramCard $program): mixed
    {
        $this->authorize('programs.edit');

        $validated = $request->validateState([
            'quote_fr' => 'required|string|max:1000',
            'quote_en' => 'required|string|max:1000',
            'author_name' => 'required|string|max:100',
            'is_published' => 'boolean',
        ]);

        $maxOrder = $program->stories()->max('sort_order') ?? 0;

        $program->stories()->create([
            'quote_fr' => strip_tags($validated['quote_fr']),
            'quote_en' => strip_tags($validated['quote_en']),
            'author_name' => strip_tags($validated['author_name']),
            'is_published' => $validated['is_published'] ?? false,
            'sort_order' => $maxOrder + 1,
        ]);

        $stories = $program->stories()->get();

        return gale()
            ->fragment('admin.programs.stories', 'stories-list', compact('program', 'stories'))
            ->state('quote_fr', '')
            ->state('quote_en', '')
            ->state('author_name', 'Bénéficiaire anonyme')
            ->state('is_published', false)
            ->dispatch('toast', ['message' => 'Témoignage ajouté', 'type' => 'success']);
    }

    public function update(Request $request, BeneficiaryStory $story): mixed
    {
        $this->authorize('programs.edit');

        $validated = $request->validateState([
            'editQuoteFr' => 'required|string|max:1000',
            'editQuoteEn' => 'required|string|max:1000',
            'editAuthor' => 'required|string|max:100',
            'editPublished' => 'boolean',
        ]);

        $story->update([
            'quote_fr' => strip_tags($validated['editQuoteFr']),
            'quote_en' => strip_tags($validated['editQuoteEn']),
            'author_name' => strip_tags($validated['editAuthor']),
            'is_published' => $validated['editPublished'] ?? false,
        ]);

        $program = $story->programCard;
        $stories = $program->stories()->get();

        return gale()
            ->fragment('admin.programs.stories', 'stories-list', compact('program', 'stories'))
            ->state('editingId', null)
            ->dispatch('toast', ['message' => 'Témoignage mis à jour', 'type' => 'success']);
    }

    public function destroy(BeneficiaryStory $story): mixed
    {
        $this->authorize('programs.edit');

        $program = $story->programCard;
        $story->delete();

        $stories = $program->stories()->get();

        return gale()
            ->fragment('admin.programs.stories', 'stories-list', compact('program', 'stories'))
            ->dispatch('toast', ['message' => 'Témoignage supprimé', 'type' => 'success']);
    }
}
