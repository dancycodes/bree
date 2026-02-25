<?php

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    Permission::findOrCreate('news.edit');
    $this->admin->givePermissionTo('news.edit');
});

it('admin can view categories index', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.news.categories.index'))
        ->assertSuccessful();
});

it('unauthenticated user cannot access categories', function () {
    $this->get(route('admin.news.categories.index'))
        ->assertRedirect('/admin/login');
});

it('admin can create a category', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.news.categories.store'), [
            'name_fr' => 'Santé',
            'name_en' => 'Health',
            'slug' => 'sante',
            'color' => '#c80078',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('news_categories', [
        'name_fr' => 'Santé',
        'slug' => 'sante',
    ]);
});

it('requires both fr and en names when creating a category', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.news.categories.store'), [
            'name_fr' => '',
            'name_en' => '',
            'slug' => 'sante',
            'color' => '#c80078',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseMissing('news_categories', ['slug' => 'sante']);
});

it('admin can update a category', function () {
    $category = NewsCategory::factory()->create([
        'name_fr' => 'Santé',
        'name_en' => 'Health',
        'slug' => 'sante',
        'color' => '#c80078',
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.news.categories.update', $category), [
            'editNameFr' => 'Éducation',
            'editNameEn' => 'Education',
            'editSlug' => 'education',
            'editColor' => '#002850',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('news_categories', [
        'id' => $category->id,
        'name_fr' => 'Éducation',
        'slug' => 'education',
    ]);
});

it('admin can delete a category with no articles', function () {
    $category = NewsCategory::factory()->create(['slug' => 'empty-cat']);

    $this->actingAs($this->admin)
        ->deleteJson(route('admin.news.categories.destroy', $category), [], ['Gale-Request' => '1']);

    $this->assertDatabaseMissing('news_categories', ['id' => $category->id]);
});

it('admin cannot delete a category that has articles', function () {
    $category = NewsCategory::factory()->create(['slug' => 'programmes']);

    NewsArticle::factory()->create([
        'category_slug' => 'programmes',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->deleteJson(route('admin.news.categories.destroy', $category), [], ['Gale-Request' => '1']);

    $this->assertDatabaseHas('news_categories', ['id' => $category->id]);
});

it('slug must be unique when creating', function () {
    NewsCategory::factory()->create(['slug' => 'sante']);

    $this->actingAs($this->admin)
        ->postJson(route('admin.news.categories.store'), [
            'name_fr' => 'Santé 2',
            'name_en' => 'Health 2',
            'slug' => 'sante',
            'color' => '#c80078',
        ], ['Gale-Request' => '1']);

    expect(NewsCategory::where('slug', 'sante')->count())->toBe(1);
});
