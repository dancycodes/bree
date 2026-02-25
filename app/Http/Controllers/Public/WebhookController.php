<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\DonationConfirmation;
use App\Models\Donation;
use Flutterwave\Payments\Facades\Flutterwave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function flutterwave(Request $request): JsonResponse
    {
        $body = $request->getContent();
        $webhook = Flutterwave::use('webhooks');
        $signature = $request->header($webhook::SECURE_HEADER, '');

        if (! $webhook->verifySignature($body, $signature)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $hookData = $webhook->getHook();
        $txRef = $hookData['tx_ref'] ?? null;
        $flutterwaveId = (string) ($hookData['id'] ?? '');

        if (! $txRef) {
            Log::channel('flutterwave')->warning('Webhook received without tx_ref');

            return response()->json(['status' => 'ok', 'message' => 'Missing tx_ref'], 200);
        }

        $donation = Donation::where('tx_ref', $txRef)->first();

        if (! $donation) {
            Log::channel('flutterwave')->warning("Webhook received for unknown tx_ref: {$txRef}");

            return response()->json(['status' => 'ok', 'message' => 'Unknown donation'], 200);
        }

        if ($donation->isCompleted()) {
            return response()->json(['status' => 'ok', 'message' => 'Already processed'], 200);
        }

        $verification = Flutterwave::use('transactions')->verifyTransactionReference($txRef);
        $txStatus = $verification['data']['status'] ?? 'failed';

        $newStatus = match ($txStatus) {
            'successful' => 'completed',
            'pending' => 'pending',
            default => 'failed',
        };

        $donation->update([
            'flutterwave_id' => $flutterwaveId,
            'status' => $newStatus,
            'flutterwave_data' => $verification['data'] ?? null,
        ]);

        if ($newStatus === 'completed') {
            Mail::to($donation->donor_email)->queue(new DonationConfirmation($donation));
        }

        return response()->json(['status' => 'success', 'message' => 'Webhook processed']);
    }
}
