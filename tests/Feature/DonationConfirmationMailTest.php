<?php

use App\Mail\DonationConfirmation;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a personalized subject containing the donor name', function () {
    $donation = Donation::factory()->completed()->create([
        'donor_name' => 'Marie Curie',
    ]);

    $mail = new DonationConfirmation($donation);
    $envelope = $mail->envelope();

    expect($envelope->subject)->toContain('Marie Curie');
});

it('has reply-to set to the foundation contact address', function () {
    $donation = Donation::factory()->completed()->create();

    $mail = new DonationConfirmation($donation);
    $envelope = $mail->envelope();

    $replyTo = collect($envelope->replyTo)->first();
    expect($replyTo->address)->toBe('contact@breefondation.org');
});

it('renders the donor name in the email body', function () {
    $donation = Donation::factory()->completed()->create([
        'donor_name' => 'Jean Dupont',
        'amount' => 50.00,
        'programme' => 'general',
        'tx_ref' => 'BREE-TEST-001',
    ]);

    $mail = new DonationConfirmation($donation);
    $rendered = $mail->render();

    expect($rendered)->toContain('Jean Dupont');
});

it('renders the donation amount in the email body', function () {
    $donation = Donation::factory()->completed()->create([
        'amount' => 75.00,
        'tx_ref' => 'BREE-TEST-002',
    ]);

    $mail = new DonationConfirmation($donation);
    $rendered = $mail->render();

    expect($rendered)->toContain('75');
});

it('renders the transaction reference in the email body', function () {
    $donation = Donation::factory()->completed()->create([
        'tx_ref' => 'BREE-TX-ABCDEF',
    ]);

    $mail = new DonationConfirmation($donation);
    $rendered = $mail->render();

    expect($rendered)->toContain('BREE-TX-ABCDEF');
});

it('renders the programme name in the email body', function () {
    $donation = Donation::factory()->completed()->create([
        'programme' => 'bree-eleve',
    ]);

    $mail = new DonationConfirmation($donation);
    $rendered = $mail->render();

    expect($rendered)->toContain('ÉLÈVE');
});

it('defaults to general fund programme label when programme is general', function () {
    $donation = Donation::factory()->completed()->create([
        'programme' => 'general',
    ]);

    $mail = new DonationConfirmation($donation);
    $rendered = $mail->render();

    expect($rendered)->toContain('général');
});

it('is queued via ShouldQueue', function () {
    $donation = Donation::factory()->completed()->create();
    $mail = new DonationConfirmation($donation);

    expect($mail)->toBeInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class);
});
