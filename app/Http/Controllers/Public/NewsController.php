<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request): mixed
    {
        $category = $request->input('category', 'all');

        $query = NewsArticle::published();

        if ($category !== 'all') {
            $query->byCategory($category);
        }

        $articles = $query->paginate(9)->withQueryString();

        $categories = NewsArticle::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereNotNull('category_slug')
            ->select('category_fr', 'category_en', 'category_slug')
            ->distinct()
            ->orderBy('category_fr')
            ->get();

        if ($request->isGaleNavigate('articles')) {
            return gale()->fragment('public.news.index', 'articles-grid', compact('articles', 'category', 'categories'));
        }

        return gale()->view('public.news.index', compact('articles', 'category', 'categories'), web: true);
    }
}
