<?php

use App\Models\ProgramCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    Permission::findOrCreate('programs.view');
    Permission::findOrCreate('programs.edit');
    $this->admin->givePermissionTo(['programs.view', 'programs.edit']);

    $this->program = ProgramCard::create([
        'slug' => 'education',
        'name_fr' => 'Éducation',
        'name_en' => 'Education',
        'description_fr' => 'Description FR',
        'description_en' => 'Description EN',
        'color' => '#c80078',
        'url' => '/programmes/education',
        'sort_order' => 1,
        'is_active' => true,
    ]);
});

it('admin can view the stories page for a program', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.programs.stories.index', $this->program))
        ->assertSuccessful()
        ->assertSee('Témoignages');
});

it('unauthenticated user is redirected from stories page', function () {
    $this->get(route('admin.programs.stories.index', $this->program))
        ->assertRedirect('/admin/login');
});

it('unauthorized user cannot access stories page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.programs.stories.index', $this->program))
        ->assertForbidden();
});

it('admin can add a story', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.programs.stories.store', $this->program), [
            'quote_fr' => 'Ce programme a changé ma vie.',
            'quote_en' => 'This programme changed my life.',
            'author_name' => 'Marie Dupont',
            'is_published' => true,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseHas('beneficiary_stories', [
        'program_card_id' => $this->program->id,
        'quote_fr' => 'Ce programme a changé ma vie.',
        'author_name' => 'Marie Dupont',
        'is_published' => true,
    ]);
});

it('story store does not save when required fields are empty', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.programs.stories.store', $this->program), [
            'quote_fr' => '',
            'quote_en' => '',
            'author_name' => '',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseMissing('beneficiary_stories', ['program_card_id' => $this->program->id]);
});

it('admin can update a story', function () {
    $story = $this->program->stories()->create([
        'quote_fr' => 'Citation originale FR',
        'quote_en' => 'Original quote EN',
        'author_name' => 'Auteur original',
        'is_published' => false,
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.programs.stories.update', $story), [
            'editQuoteFr' => 'Citation mise à jour FR',
            'editQuoteEn' => 'Updated quote EN',
            'editAuthor' => 'Auteur mis à jour',
            'editPublished' => true,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseHas('beneficiary_stories', [
        'id' => $story->id,
        'quote_fr' => 'Citation mise à jour FR',
        'author_name' => 'Auteur mis à jour',
        'is_published' => true,
    ]);
});

it('admin can delete a story', function () {
    $story = $this->program->stories()->create([
        'quote_fr' => 'À supprimer',
        'quote_en' => 'To delete',
        'author_name' => 'Auteur',
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->deleteJson(route('admin.programs.stories.destroy', $story), [], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseMissing('beneficiary_stories', ['id' => $story->id]);
});

it('stories page shows existing stories', function () {
    $this->program->stories()->create([
        'quote_fr' => 'Un témoignage inspirant',
        'quote_en' => 'An inspiring testimonial',
        'author_name' => 'Bénéficiaire Test',
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.programs.stories.index', $this->program))
        ->assertSee('Un témoignage inspirant')
        ->assertSee('Bénéficiaire Test');
});
