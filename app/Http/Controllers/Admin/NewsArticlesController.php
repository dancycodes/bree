<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsArticlesController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('news.view');

        $articles = NewsArticle::orderByDesc('created_at')->paginate(20);

        return gale()->view('admin.news.index', compact('articles'), web: true);
    }

    public function create(): mixed
    {
        $this->authorize('news.create');

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()->view('admin.news.create', compact('categories'), web: true);
    }

    public function store(Request $request): mixed
    {
        $this->authorize('news.create');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:news_articles,slug',
            'excerpt_fr' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content_fr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'category_slug' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $categoryFr = 'Actualités';
        $categoryEn = 'News';

        if ($request->input('category_slug')) {
            $cat = NewsCategory::where('slug', $request->input('category_slug'))->first();
            if ($cat) {
                $categoryFr = $cat->name_fr;
                $categoryEn = $cat->name_en;
            }
        }

        $publishedAt = null;
        if ($request->input('status') === 'published') {
            $publishedAt = $request->input('published_at') ?: now();
        }

        $article = NewsArticle::create([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'excerpt_fr' => $request->input('excerpt_fr') ? strip_tags($request->input('excerpt_fr')) : null,
            'excerpt_en' => $request->input('excerpt_en') ? strip_tags($request->input('excerpt_en')) : null,
            'content_fr' => $request->input('content_fr'),
            'content_en' => $request->input('content_en'),
            'category_slug' => $request->input('category_slug') ?: null,
            'category_fr' => $categoryFr,
            'category_en' => $categoryEn,
            'status' => $request->input('status'),
            'published_at' => $publishedAt,
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
            $article->update(['thumbnail_path' => 'storage/'.$path]);
        }

        return gale()->redirect(route('admin.news.edit', $article));
    }

    public function edit(NewsArticle $article): mixed
    {
        $this->authorize('news.edit');

        $categories = NewsCategory::orderBy('name_fr')->get();

        return gale()->view('admin.news.edit', compact('article', 'categories'), web: true);
    }

    public function update(Request $request, NewsArticle $article): mixed
    {
        $this->authorize('news.edit');

        $request->validate([
            'title_fr' => 'required|string|max:300',
            'title_en' => 'required|string|max:300',
            'slug' => 'required|string|max:300|regex:/^[a-z0-9-]+$/|unique:news_articles,slug,'.$article->id,
            'excerpt_fr' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content_fr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'category_slug' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $categoryFr = 'Actualités';
        $categoryEn = 'News';

        if ($request->input('category_slug')) {
            $cat = NewsCategory::where('slug', $request->input('category_slug'))->first();
            if ($cat) {
                $categoryFr = $cat->name_fr;
                $categoryEn = $cat->name_en;
            }
        }

        $publishedAt = $article->published_at;
        if ($request->input('status') === 'published' && ! $publishedAt) {
            $publishedAt = $request->input('published_at') ?: now();
        } elseif ($request->input('published_at')) {
            $publishedAt = $request->input('published_at');
        }

        $thumbnailPath = $article->thumbnail_path;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles', 'public');
            $thumbnailPath = 'storage/'.$path;
        }

        $article->update([
            'slug' => $request->input('slug'),
            'title_fr' => strip_tags($request->input('title_fr')),
            'title_en' => strip_tags($request->input('title_en')),
            'excerpt_fr' => $request->input('excerpt_fr') ? strip_tags($request->input('excerpt_fr')) : null,
            'excerpt_en' => $request->input('excerpt_en') ? strip_tags($request->input('excerpt_en')) : null,
            'content_fr' => $request->input('content_fr'),
            'content_en' => $request->input('content_en'),
            'category_slug' => $request->input('category_slug') ?: null,
            'category_fr' => $categoryFr,
            'category_en' => $categoryEn,
            'status' => $request->input('status'),
            'published_at' => $publishedAt,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return gale()->dispatch('toast', ['message' => 'Article sauvegardé', 'type' => 'success']);
    }

    public function destroy(NewsArticle $article): mixed
    {
        $this->authorize('news.delete');

        $article->delete();

        return gale()->redirect(route('admin.news.index'));
    }
}
