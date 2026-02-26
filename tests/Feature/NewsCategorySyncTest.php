<?php

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Model relationships ───────────────────────────────────────────────────────

it('news_articles table has news_category_id column', function () {
    expect(\Illuminate\Support\Facades\Schema::hasColumn('news_articles', 'news_category_id'))->toBeTrue();
});

it('NewsArticle has a belongsTo newsCategory relationship', function () {
    $category = NewsCategory::factory()->create(['slug' => 'programmes']);
    $article = NewsArticle::factory()->create([
        'news_category_id' => $category->id,
        'category_slug' => 'programmes',
    ]);

    expect($article->newsCategory)->toBeInstanceOf(NewsCategory::class);
    expect($article->newsCategory->id)->toBe($category->id);
});

it('NewsCategory has a hasMany articles relationship', function () {
    $category = NewsCategory::factory()->create(['slug' => 'environnement']);

    NewsArticle::factory()->count(3)->create([
        'news_category_id' => $category->id,
        'category_slug' => 'environnement',
    ]);

    expect($category->articles)->toHaveCount(3);
});

it('news_category_id is nullable and does not cascade delete articles', function () {
    $category = NewsCategory::factory()->create(['slug' => 'rapports']);
    $article = NewsArticle::factory()->create([
        'news_category_id' => $category->id,
        'category_slug' => 'rapports',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $category->delete();

    $article->refresh();
    expect($article->news_category_id)->toBeNull();
    expect(NewsArticle::find($article->id))->not->toBeNull();
});

// ── categoryLabel() helper ───────────────────────────────────────────────────

it('categoryLabel returns normalized category name when newsCategory is loaded', function () {
    $category = NewsCategory::factory()->create([
        'name_fr' => 'Environnement',
        'name_en' => 'Environment',
        'slug' => 'environnement',
    ]);

    $article = NewsArticle::factory()->create([
        'news_category_id' => $category->id,
        'category_fr' => 'Old FR',
        'category_en' => 'Old EN',
    ]);

    app()->setLocale('fr');
    expect($article->categoryLabel())->toBe('Environnement');

    app()->setLocale('en');
    expect($article->categoryLabel())->toBe('Environment');
});

it('categoryLabel falls back to denormalized columns when no relationship', function () {
    $article = NewsArticle::factory()->create([
        'news_category_id' => null,
        'category_fr' => 'Actualités',
        'category_en' => 'News',
    ]);

    app()->setLocale('fr');
    expect($article->categoryLabel())->toBe('Actualités');

    app()->setLocale('en');
    expect($article->categoryLabel())->toBe('News');
});

// ── scopeByCategory ──────────────────────────────────────────────────────────

it('scopeByCategory filters articles by news_category_id', function () {
    $catA = NewsCategory::factory()->create(['slug' => 'programmes']);
    $catB = NewsCategory::factory()->create(['slug' => 'sante']);

    NewsArticle::factory()->count(2)->create([
        'news_category_id' => $catA->id,
        'status' => 'published',
        'published_at' => now(),
    ]);
    NewsArticle::factory()->count(1)->create([
        'news_category_id' => $catB->id,
        'status' => 'published',
        'published_at' => now(),
    ]);

    $result = NewsArticle::published()->byCategory($catA->id)->get();

    expect($result)->toHaveCount(2);
    expect($result->every(fn ($a) => $a->news_category_id === $catA->id))->toBeTrue();
});

// ── Public filter ────────────────────────────────────────────────────────────

it('public news index loads categories from news_categories table', function () {
    NewsCategory::factory()->create(['name_fr' => 'Programmes', 'slug' => 'programmes']);
    NewsCategory::factory()->create(['name_fr' => 'Environnement', 'slug' => 'environnement']);

    $response = $this->get(route('public.news'));

    $response->assertSuccessful();
    $response->assertSee('Programmes');
    $response->assertSee('Environnement');
});

it('public news filter returns only articles matching selected category', function () {
    $catA = NewsCategory::factory()->create(['name_fr' => 'Programmes', 'slug' => 'programmes']);
    $catB = NewsCategory::factory()->create(['name_fr' => 'Santé', 'slug' => 'sante']);

    $articleA = NewsArticle::factory()->create([
        'title_fr' => 'Article Programmes',
        'news_category_id' => $catA->id,
        'status' => 'published',
        'published_at' => now(),
    ]);
    $articleB = NewsArticle::factory()->create([
        'title_fr' => 'Article Santé',
        'news_category_id' => $catB->id,
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = $this->get(route('public.news', ['category' => 'programmes']));

    $response->assertSuccessful();
    $response->assertSee('Article Programmes');
    $response->assertDontSee('Article Santé');
});

it('public news filter Tous shows all published articles', function () {
    $catA = NewsCategory::factory()->create(['slug' => 'programmes']);
    $catB = NewsCategory::factory()->create(['slug' => 'sante']);

    NewsArticle::factory()->create([
        'title_fr' => 'Article A',
        'news_category_id' => $catA->id,
        'status' => 'published',
        'published_at' => now(),
    ]);
    NewsArticle::factory()->create([
        'title_fr' => 'Article B',
        'news_category_id' => $catB->id,
        'status' => 'published',
        'published_at' => now(),
    ]);

    $response = $this->get(route('public.news'));

    $response->assertSuccessful();
    $response->assertSee('Article A');
    $response->assertSee('Article B');
});

it('articles with no news_category_id appear under Tous only', function () {
    $cat = NewsCategory::factory()->create(['slug' => 'programmes']);

    NewsArticle::factory()->create([
        'title_fr' => 'Uncategorized Article',
        'news_category_id' => null,
        'status' => 'published',
        'published_at' => now(),
    ]);

    // Under "all" — should appear
    $allResponse = $this->get(route('public.news'));
    $allResponse->assertSee('Uncategorized Article');

    // Under a specific category — should not appear
    $filteredResponse = $this->get(route('public.news', ['category' => 'programmes']));
    $filteredResponse->assertDontSee('Uncategorized Article');
});

// ── articlesCount on NewsCategory ────────────────────────────────────────────

it('NewsCategory articlesCount returns count of published articles via relationship', function () {
    $category = NewsCategory::factory()->create(['slug' => 'programmes']);

    NewsArticle::factory()->count(2)->create([
        'news_category_id' => $category->id,
        'status' => 'published',
        'published_at' => now(),
    ]);
    // Draft should not count
    NewsArticle::factory()->draft()->create([
        'news_category_id' => $category->id,
    ]);

    expect($category->articlesCount())->toBe(2);
});
