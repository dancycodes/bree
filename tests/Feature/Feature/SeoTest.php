<?php

use App\Models\FoundationEvent;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('homepage has title and meta description', function () {
    $this->get(route('public.home'))
        ->assertStatus(200)
        ->assertSee('Fondation BREE', false)
        ->assertSee('<meta name="description"', false);
});

it('homepage has open graph tags', function () {
    $this->get(route('public.home'))
        ->assertStatus(200)
        ->assertSee('<meta property="og:title"', false)
        ->assertSee('<meta property="og:description"', false)
        ->assertSee('<meta property="og:image"', false)
        ->assertSee('<meta property="og:url"', false);
});

it('homepage has twitter card tags', function () {
    $this->get(route('public.home'))
        ->assertStatus(200)
        ->assertSee('twitter:card', false)
        ->assertSee('twitter:title', false)
        ->assertSee('twitter:image', false);
});

it('homepage has canonical link', function () {
    $this->get(route('public.home'))
        ->assertStatus(200)
        ->assertSee('<link rel="canonical"', false);
});

it('news article has its title in og tags', function () {
    $article = NewsArticle::factory()->create([
        'slug' => 'test-article',
        'title_fr' => 'Article de test SEO',
        'title_en' => 'SEO Test Article',
        'excerpt_fr' => 'Extrait de test',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('public.news.show', $article->slug))
        ->assertStatus(200)
        ->assertSee('Article de test SEO', false)
        ->assertSee('<meta property="og:title"', false)
        ->assertSee('<meta property="og:image"', false);
});

it('news article with thumbnail sets og image to thumbnail url', function () {
    $article = NewsArticle::factory()->create([
        'slug' => 'article-with-thumb',
        'title_fr' => 'Article avec miniature',
        'status' => 'published',
        'published_at' => now(),
        'thumbnail_path' => 'images/sections/news-placeholder.jpg',
    ]);

    $this->get(route('public.news.show', $article->slug))
        ->assertStatus(200)
        ->assertSee('images/sections/news-placeholder.jpg', false);
});

it('news article without thumbnail falls back to logo', function () {
    $article = NewsArticle::factory()->create([
        'slug' => 'article-no-thumb',
        'title_fr' => 'Article sans miniature',
        'status' => 'published',
        'published_at' => now(),
        'thumbnail_path' => null,
    ]);

    $this->get(route('public.news.show', $article->slug))
        ->assertStatus(200)
        ->assertSee('images/logo.png', false);
});

it('sitemap returns valid xml with static pages', function () {
    $this->get(route('sitemap'))
        ->assertStatus(200)
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee('http://www.sitemaps.org/schemas/sitemap/0.9', false)
        ->assertSee(route('public.home'), false)
        ->assertSee(route('public.about'), false)
        ->assertSee(route('public.news'), false)
        ->assertSee(route('public.events'), false)
        ->assertSee(route('public.donate'), false);
});

it('sitemap includes published articles', function () {
    NewsArticle::factory()->create([
        'slug' => 'sitemap-test-article',
        'title_fr' => 'Article pour sitemap',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('sitemap'))
        ->assertStatus(200)
        ->assertSee('sitemap-test-article', false);
});

it('sitemap includes published events', function () {
    FoundationEvent::create([
        'slug' => 'sitemap-test-event',
        'title_fr' => 'Événement pour sitemap',
        'title_en' => 'Sitemap test event',
        'is_published' => true,
        'event_date' => now()->addDays(10)->toDateString(),
    ]);

    $this->get(route('sitemap'))
        ->assertStatus(200)
        ->assertSee('sitemap-test-event', false);
});
