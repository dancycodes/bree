<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show(NewsArticle $article): mixed
    {
        if ($article->status !== 'published' || ! $article->published_at) {
            abort(404);
        }

        $related = NewsArticle::published()
            ->where('id', '!=', $article->id)
            ->when($article->category_slug, fn ($q) => $q->where('category_slug', $article->category_slug))
            ->limit(3)
            ->get();

        return gale()->view('public.news.show', compact('article', 'related'), web: true);
    }

    public function index(Request $request): mixed
    {
        $category = $request->input('category', 'all');

        $query = NewsArticle::published();

        if ($category !== 'all') {
            $query->byCategory($category);
        }

        $articles = $query->paginate(9)->withQueryString();

        $categories = NewsCategory::query()
            ->orderBy('name_fr')
            ->get();

        if ($request->isGaleNavigate('articles')) {
            return gale()->fragment('public.news.index', 'articles-grid', compact('articles', 'category', 'categories'));
        }

        return gale()->view('public.news.index', compact('articles', 'category', 'categories'), web: true);
    }
}
