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

        $article->load('newsCategory');

        $related = NewsArticle::published()
            ->with('newsCategory')
            ->where('id', '!=', $article->id)
            ->when($article->news_category_id, fn ($q) => $q->where('news_category_id', $article->news_category_id))
            ->limit(3)
            ->get();

        return gale()->view('public.news.show', compact('article', 'related'), web: true);
    }

    public function index(Request $request): mixed
    {
        $categorySlug = $request->input('category', 'all');

        $categories = NewsCategory::query()
            ->orderBy('name_fr')
            ->get();

        $activeCategory = $categorySlug !== 'all'
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        $query = NewsArticle::published()->with('newsCategory');

        if ($activeCategory !== null) {
            $query->byCategory($activeCategory->id);
        }

        $articles = $query->paginate(9)->withQueryString();

        // Pass the slug for active state matching in the view
        $category = $categorySlug;

        if ($request->isGaleNavigate('articles')) {
            return gale()->fragment('public.news.index', 'articles-grid', compact('articles', 'category', 'categories'));
        }

        return gale()->view('public.news.index', compact('articles', 'category', 'categories'), web: true);
    }
}
