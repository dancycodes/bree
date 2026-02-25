<?php

use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    Permission::findOrCreate('donations.export');
    Permission::findOrCreate('donations.view');
    $this->admin->givePermissionTo(['donations.export', 'donations.view']);
});

it('admin can download donations CSV', function () {
    Donation::factory()->create([
        'donor_name' => 'Alice Martin',
        'donor_email' => 'alice@example.com',
        'amount' => 50,
        'currency' => 'EUR',
        'status' => 'completed',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.donations.export'));

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    expect($response->streamedContent())->toContain('Alice Martin');
});

it('CSV includes expected column headers', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.donations.export'));

    $content = $response->streamedContent();
    expect($content)
        ->toContain('Nom')
        ->toContain('Email')
        ->toContain('Type')
        ->toContain('Montant')
        ->toContain('Statut');
});

it('unauthenticated user cannot export donations', function () {
    $this->get(route('admin.donations.export'))
        ->assertRedirect('/admin/login');
});

it('unauthorized user cannot export donations', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.donations.export'))
        ->assertForbidden();
});

it('export respects type filter', function () {
    Donation::factory()->create([
        'donor_name' => 'Ponctuel Dupont',
        'status' => 'completed',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.donations.export', ['type' => 'pledge']));

    $content = $response->streamedContent();
    expect($content)->not->toContain('Ponctuel Dupont');
});

it('empty filter returns CSV with headers only', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.donations.export', ['type' => 'pledge']));

    $response->assertSuccessful();
    expect($response->streamedContent())->toContain('Nom');
});
