<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Flutterwave\Payments\Facades\Flutterwave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function flutterwave(Request $request): JsonResponse
    {
        $body = $request->getContent();
        $webhook = Flutterwave::use('webhooks');
        $signature = $request->header($webhook::SECURE_HEADER, '');

        if (! $webhook->verifySignature($body, $signature)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
        }

        $hookData = $webhook->getHook();
        $txRef = $hookData['tx_ref'] ?? null;
        $flutterwaveId = (string) ($hookData['id'] ?? '');

        if (! $txRef) {
            return response()->json(['status' => 'error', 'message' => 'Missing tx_ref'], 400);
        }

        $donation = Donation::where('tx_ref', $txRef)->first();

        if (! $donation) {
            return response()->json(['status' => 'error', 'message' => 'Donation not found'], 404);
        }

        $verification = Flutterwave::use('transactions')->verifyTransactionReference($txRef);
        $verified = ($verification['status'] ?? '') === 'success';
        $txStatus = $verification['data']['status'] ?? 'failed';

        $donation->update([
            'flutterwave_id' => $flutterwaveId,
            'status' => match ($txStatus) {
                'successful' => 'completed',
                'pending' => 'pending',
                default => 'failed',
            },
            'flutterwave_data' => $verification['data'] ?? null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Webhook processed']);
    }
}
