<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationEvent;
use App\Models\NewsArticle;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticUrls = [
            ['loc' => route('public.home'),     'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('public.about'),    'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('public.programs'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('public.news'),     'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('public.events'),   'priority' => '0.7', 'changefreq' => 'daily'],
            ['loc' => route('public.gallery'),  'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => route('public.partners'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('public.contact'),  'priority' => '0.6', 'changefreq' => 'yearly'],
            ['loc' => route('public.donate'),   'priority' => '0.9', 'changefreq' => 'monthly'],
        ];

        $articles = NewsArticle::published()
            ->select('slug', 'updated_at')
            ->get()
            ->map(fn (NewsArticle $article) => [
                'loc' => route('public.news.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ]);

        $events = FoundationEvent::query()
            ->where('is_published', true)
            ->select('slug', 'updated_at')
            ->get()
            ->map(fn (FoundationEvent $event) => [
                'loc' => route('public.events.show', $event->slug),
                'lastmod' => $event->updated_at->toAtomString(),
                'priority' => '0.6',
                'changefreq' => 'weekly',
            ]);

        $urls = array_merge($staticUrls, $articles->toArray(), $events->toArray());

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
