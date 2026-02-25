<?php

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    Permission::findOrCreate('about.edit');
    $this->admin->givePermissionTo('about.edit');
});

it('admin can view the team members index', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.about.team.index'))
        ->assertSuccessful()
        ->assertSee('Membres');
});

it('unauthenticated user is redirected from team page', function () {
    $this->get(route('admin.about.team.index'))
        ->assertRedirect('/admin/login');
});

it('unauthorized user cannot access team page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.about.team.index'))
        ->assertForbidden();
});

it('admin can add a team member', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.about.team.store'), [
            'name' => 'Amina Diallo',
            'title_fr' => 'Directrice Générale',
            'title_en' => 'Executive Director',
            'is_published' => true,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseHas('team_members', [
        'name' => 'Amina Diallo',
        'title_fr' => 'Directrice Générale',
        'is_published' => true,
    ]);
});

it('store validates required fields', function () {
    $this->actingAs($this->admin)
        ->postJson(route('admin.about.team.store'), [
            'name' => '',
            'title_fr' => '',
            'title_en' => '',
        ], ['Gale-Request' => '1']);

    $this->assertDatabaseCount('team_members', 0);
});

it('admin can view the team member edit page', function () {
    $member = TeamMember::create([
        'name' => 'Test Member',
        'title_fr' => 'Titre FR',
        'title_en' => 'Title EN',
        'is_published' => true,
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.about.team.edit', $member))
        ->assertSuccessful()
        ->assertSee('Test Member');
});

it('admin can update a team member', function () {
    $member = TeamMember::create([
        'name' => 'Old Name',
        'title_fr' => 'Old Title FR',
        'title_en' => 'Old Title EN',
        'is_published' => false,
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->patchJson(route('admin.about.team.update', $member), [
            'name' => 'New Name',
            'title_fr' => 'New Title FR',
            'title_en' => 'New Title EN',
            'is_published' => true,
        ], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseHas('team_members', [
        'id' => $member->id,
        'name' => 'New Name',
        'title_fr' => 'New Title FR',
        'is_published' => true,
    ]);
});

it('admin can delete a team member', function () {
    $member = TeamMember::create([
        'name' => 'À Supprimer',
        'title_fr' => 'Titre',
        'title_en' => 'Title',
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->deleteJson(route('admin.about.team.destroy', $member), [], ['Gale-Request' => '1'])
        ->assertSuccessful();

    $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
});

it('team index shows existing members', function () {
    TeamMember::create([
        'name' => 'Sophie Martin',
        'title_fr' => 'Coordinatrice',
        'title_en' => 'Coordinator',
        'sort_order' => 1,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.about.team.index'))
        ->assertSee('Sophie Martin');
});
