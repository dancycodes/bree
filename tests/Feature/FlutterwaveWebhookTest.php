<?php

use App\Mail\DonationConfirmation;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

const WEBHOOK_URL = '/webhook/flutterwave';
const SECRET_HASH = 'test-webhook-secret-hash';
const FLW_API_PATTERN = 'https://api.flutterwave.com/*';

beforeEach(function () {
    config([
        'flutterwave.secretHash' => SECRET_HASH,
        'flutterwave.secretKey' => 'test-secret-key',
    ]);
    Mail::fake();
});

function webhookPayload(string $txRef, string $status = 'successful', int $flwId = 12345): array
{
    return [
        'event' => 'charge.completed',
        'data' => [
            'id' => $flwId,
            'tx_ref' => $txRef,
            'status' => $status,
            'amount' => 100,
            'currency' => 'EUR',
        ],
    ];
}

function fakeFlutterwaveVerification(string $txRef, string $status = 'successful', float $amount = 100.00): void
{
    Http::fake([
        FLW_API_PATTERN => Http::response([
            'status' => 'success',
            'data' => [
                'id' => 12345,
                'tx_ref' => $txRef,
                'status' => $status,
                'amount' => $amount,
                'currency' => 'EUR',
            ],
        ], 200),
    ]);
}

it('returns 403 for invalid webhook signature', function () {
    $donation = Donation::factory()->create(['tx_ref' => 'BREE-001']);

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-001'), [
        'verif-hash' => 'wrong-signature',
    ])->assertStatus(403);

    Mail::assertNothingQueued();
    expect($donation->fresh()->status)->toBe('pending');
});

it('processes valid webhook and marks donation as completed', function () {
    $donation = Donation::factory()->create(['tx_ref' => 'BREE-002', 'status' => 'pending']);
    fakeFlutterwaveVerification('BREE-002');

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-002'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200)->assertJson(['status' => 'success']);

    expect($donation->fresh()->status)->toBe('completed');
    Mail::assertQueued(DonationConfirmation::class, fn ($mail) => $mail->donation->tx_ref === 'BREE-002');
});

it('sends confirmation email to donor email after successful payment', function () {
    $donation = Donation::factory()->create([
        'tx_ref' => 'BREE-003',
        'donor_email' => 'donor@example.com',
        'status' => 'pending',
    ]);
    fakeFlutterwaveVerification('BREE-003');

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-003'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200);

    Mail::assertQueued(DonationConfirmation::class, function ($mail) use ($donation) {
        $mail->to('donor@example.com');

        return $mail->donation->is($donation);
    });
});

it('is idempotent and returns 200 for already completed donation', function () {
    $donation = Donation::factory()->completed()->create(['tx_ref' => 'BREE-004']);

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-004'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200)->assertJson(['status' => 'ok', 'message' => 'Already processed']);

    Http::assertNothingSent();
    Mail::assertNothingQueued();
});

it('returns 200 for unknown donation and does not crash', function () {
    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-UNKNOWN'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200)->assertJson(['status' => 'ok']);

    Mail::assertNothingQueued();
});

it('marks donation as failed when flutterwave reports failed status', function () {
    $donation = Donation::factory()->create(['tx_ref' => 'BREE-005', 'status' => 'pending']);
    fakeFlutterwaveVerification('BREE-005', 'failed');

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-005', 'failed'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200);

    expect($donation->fresh()->status)->toBe('failed');
    Mail::assertNothingQueued();
});

it('does not send confirmation email for failed payments', function () {
    Donation::factory()->create(['tx_ref' => 'BREE-006', 'status' => 'pending']);
    fakeFlutterwaveVerification('BREE-006', 'failed');

    $this->postJson(WEBHOOK_URL, webhookPayload('BREE-006', 'failed'), [
        'verif-hash' => SECRET_HASH,
    ])->assertStatus(200);

    Mail::assertNothingQueued();
});
