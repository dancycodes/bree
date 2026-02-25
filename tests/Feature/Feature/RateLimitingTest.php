<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

beforeEach(function () {
    RateLimiter::clear('1.2.3.4');
});

it('contact form allows 5 submissions then blocks on the 6th', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
            ->postJson(route('public.contact.store'), []);
    }

    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
        ->postJson(route('public.contact.store'), [])
        ->assertStatus(429);
});

it('newsletter form is rate limited at 5 per minute', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
            ->postJson(route('newsletter.subscribe'), []);
    }

    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
        ->postJson(route('newsletter.subscribe'), [])
        ->assertStatus(429);
});

it('payment initiation is rate limited at 3 per minute', function () {
    for ($i = 0; $i < 3; $i++) {
        $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
            ->postJson(route('public.donate.initPayment'), []);
    }

    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
        ->postJson(route('public.donate.initPayment'), [])
        ->assertStatus(429);
});

it('rate limit response includes retry-after header', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
            ->postJson(route('public.contact.store'), []);
    }

    $this->withServerVariables(['REMOTE_ADDR' => '1.2.3.4'])
        ->postJson(route('public.contact.store'), [])
        ->assertStatus(429)
        ->assertHeader('Retry-After');
});
