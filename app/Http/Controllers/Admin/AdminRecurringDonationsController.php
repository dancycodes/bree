<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RecurringDonationCancelled;
use App\Models\RecurringDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminRecurringDonationsController extends Controller
{
    public function index(Request $request): mixed
    {
        $this->authorize('donations.view');

        $status = $request->state('status', '') ?? '';
        $search = $request->state('search', '') ?? '';

        $query = RecurringDonation::query()->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'ilike', "%{$search}%")
                    ->orWhere('donor_email', 'ilike', "%{$search}%");
            });
        }

        $donations = $query->paginate(30);

        if ($request->isGale()) {
            return gale()->fragment('admin.donations.recurring', 'recurring-list', compact('donations'));
        }

        return gale()->view('admin.donations.recurring', compact('donations'), web: true);
    }

    public function cancel(RecurringDonation $recurring): mixed
    {
        $this->authorize('donations.edit');

        if ($recurring->status === 'cancelled') {
            return gale()->dispatch('toast', [
                'message' => 'Cet abonnement est déjà annulé.',
                'type' => 'error',
            ]);
        }

        // Attempt Flutterwave API cancellation
        if ($recurring->flutterwave_subscription_id) {
            try {
                $response = Http::withToken(config('flutterwave.secretKey'))
                    ->put("https://api.flutterwave.com/v3/subscriptions/{$recurring->flutterwave_subscription_id}/cancel");

                if (! $response->successful()) {
                    Log::channel('flutterwave')->warning('Subscription cancellation API call failed', [
                        'id' => $recurring->id,
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::channel('flutterwave')->error('Subscription cancellation exception', [
                    'id' => $recurring->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $recurring->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        // Send cancellation email to donor
        if ($recurring->donor_email) {
            Mail::to($recurring->donor_email)->queue(new RecurringDonationCancelled($recurring));
        }

        $donations = RecurringDonation::query()->latest()->paginate(30);

        return gale()
            ->fragment('admin.donations.recurring', 'recurring-list', compact('donations'))
            ->dispatch('toast', ['message' => 'Abonnement annulé', 'type' => 'success']);
    }
}
