<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoriesController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('news.edit');

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()->view('admin.news.categories', compact('categories'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('news.edit');

        $validated = $request->validateState([
            'name_fr' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'slug' => 'required|string|max:100|regex:/^[a-z0-9-]+$/|unique:news_categories,slug',
            'color' => 'required|string|max:7|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        NewsCategory::create([
            'name_fr' => strip_tags($validated['name_fr']),
            'name_en' => strip_tags($validated['name_en']),
            'slug' => $validated['slug'],
            'color' => $validated['color'],
        ]);

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()
            ->fragment('admin.news.categories', 'categories-list', compact('categories'))
            ->state('name_fr', '')
            ->state('name_en', '')
            ->state('slug', '')
            ->state('color', '#c80078')
            ->dispatch('toast', ['message' => 'Catégorie créée', 'type' => 'success']);
    }

    public function update(Request $request, NewsCategory $category): mixed
    {
        $this->authorize('news.edit');

        $validated = $request->validateState([
            'editNameFr' => 'required|string|max:100',
            'editNameEn' => 'required|string|max:100',
            'editSlug' => 'required|string|max:100|regex:/^[a-z0-9-]+$/|unique:news_categories,slug,'.$category->id,
            'editColor' => 'required|string|max:7|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $category->update([
            'name_fr' => strip_tags($validated['editNameFr']),
            'name_en' => strip_tags($validated['editNameEn']),
            'slug' => $validated['editSlug'],
            'color' => $validated['editColor'],
        ]);

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()
            ->fragment('admin.news.categories', 'categories-list', compact('categories'))
            ->state('editingId', null)
            ->dispatch('toast', ['message' => 'Catégorie mise à jour', 'type' => 'success']);
    }

    public function destroy(NewsCategory $category): mixed
    {
        $this->authorize('news.edit');

        $count = NewsArticle::where('category_slug', $category->slug)->count();

        if ($count > 0) {
            return gale()
                ->dispatch('toast', [
                    'message' => "Cette catégorie est utilisée par {$count} article".($count > 1 ? 's' : '').'. Veuillez les rassigner avant de supprimer.',
                    'type' => 'error',
                ]);
        }

        $category->delete();

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()
            ->fragment('admin.news.categories', 'categories-list', compact('categories'))
            ->dispatch('toast', ['message' => 'Catégorie supprimée', 'type' => 'success']);
    }
}
