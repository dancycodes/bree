<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('homepage loads successfully', function () {
    $this->get('/')->assertSuccessful();
});

it('admin login page loads', function () {
    $this->get('/admin/login')->assertSuccessful();
});

it('unauthenticated access to admin dashboard redirects to login', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect('/admin/login');
});

it('authenticated admin can access dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertSuccessful();
});
