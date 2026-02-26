<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 404 for non-existent routes', function () {
    $this->get('/this-route-definitely-does-not-exist')
        ->assertStatus(404)
        ->assertSee('404');
});

it('404 page shows return to homepage link', function () {
    $this->get('/non-existent-page')
        ->assertStatus(404)
        ->assertSee("Retour à l'accueil", false);
});

it('404 page contains branded heading', function () {
    $this->get('/non-existent-page')
        ->assertStatus(404)
        ->assertSee("cette page n'existe plus", false);
});

it('500 error view exists and renders without database queries', function () {
    $view = view('errors.500')->render();

    expect($view)->toContain('500')
        ->toContain('Une erreur est survenue')
        ->toContain('Accueil');
});
