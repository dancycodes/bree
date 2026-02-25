<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\ImpactExample;
use App\Models\RecurringDonation;
use Flutterwave\Payments\Facades\Flutterwave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function index(Request $request): mixed
    {
        $programme = $request->input('programme', '');
        $validProgrammes = ['bree-protege', 'bree-eleve', 'bree-respire', 'general'];
        if (! in_array($programme, $validProgrammes, true)) {
            $programme = 'general';
        }

        $impactExamples = ImpactExample::published()->get();

        return gale()->view('public.donation.index', compact('programme', 'impactExamples'), web: true);
    }

    public function selectAmount(Request $request): mixed
    {
        $type = $request->state('donationType', 'direct');
        $validTypes = ['direct', 'recurring'];
        if (! in_array($type, $validTypes, true)) {
            $type = 'direct';
        }

        $impactExamples = ImpactExample::published()->get();

        return gale()
            ->fragment('public.donation.index', 'amount-selector', [
                'amountSelectorType' => $type,
                'impactExamples' => $impactExamples,
            ])
            ->state('selectorVisible', true)
            ->state('selectedAmount', 0)
            ->state('customAmount', '')
            ->state('showCustom', false)
            ->state('amountConfirmed', false)
            ->state('frequency', 'monthly');
    }

    public function validateAmount(Request $request): mixed
    {
        $showCustom = (bool) $request->state('showCustom', false);
        $type = $request->state('donationType', 'direct');
        $frequency = $request->state('frequency', 'monthly');

        if ($showCustom) {
            $rawAmount = (string) $request->state('customAmount', '');
            $amount = (float) str_replace(',', '.', $rawAmount);

            if (! is_numeric(str_replace(',', '.', $rawAmount)) || $amount <= 0) {
                return gale()->messages(['amount' => [__('donation.amount_error_numeric')]]);
            }
        } else {
            $amount = (float) $request->state('selectedAmount', 0);
        }

        if ($type === 'recurring') {
            $min = $frequency === 'yearly' ? 50 : 5;
            $errorKey = $frequency === 'yearly' ? 'donation.recurring_error_min_yearly' : 'donation.recurring_error_min_monthly';
            if ($amount < $min) {
                return gale()->messages(['amount' => [__($errorKey)]]);
            }
        } elseif ($amount < 1) {
            return gale()->messages(['amount' => [__('donation.amount_error_min')]]);
        }

        return gale()
            ->state('amountConfirmed', true)
            ->state('confirmedAmount', $amount)
            ->state('confirmedType', $type)
            ->state('confirmedFrequency', $frequency);
    }

    public function initPayment(Request $request): mixed
    {
        $donorName = trim((string) $request->state('donorName', ''));
        $donorEmail = trim((string) $request->state('donorEmail', ''));
        $donorPhone = trim((string) $request->state('donorPhone', ''));
        $donorCountry = trim((string) $request->state('donorCountry', 'CM'));
        $confirmedAmount = (float) $request->state('confirmedAmount', 0);
        $confirmedType = (string) $request->state('confirmedType', 'direct');
        $confirmedFrequency = (string) $request->state('confirmedFrequency', 'monthly');
        $programme = (string) $request->state('programme', 'general');

        if (empty($donorName)) {
            return gale()->messages(['donorName' => [__('donation.donor_name_required')]]);
        }

        if (empty($donorEmail) || ! filter_var($donorEmail, FILTER_VALIDATE_EMAIL)) {
            return gale()->messages(['donorEmail' => [__('donation.donor_email_invalid')]]);
        }

        if ($confirmedAmount < 1) {
            return gale()->messages(['amount' => [__('donation.amount_error_min')]]);
        }

        $txRef = Flutterwave::generateTransactionReference();

        if ($confirmedType === 'recurring') {
            return $this->initRecurringPayment(
                $txRef, $donorName, $donorEmail, $donorPhone,
                $donorCountry, $confirmedAmount, $confirmedFrequency, $programme
            );
        }

        Donation::create([
            'tx_ref' => $txRef,
            'amount' => $confirmedAmount,
            'currency' => 'EUR',
            'type' => $confirmedType,
            'programme' => $programme,
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,
            'donor_phone' => $donorPhone ?: null,
            'donor_country' => strtoupper($donorCountry) ?: 'CM',
            'status' => 'pending',
        ]);

        $paymentConfig = Flutterwave::render('inline', [
            'tx_ref' => $txRef,
            'amount' => $confirmedAmount,
            'currency' => 'EUR',
            'customer' => [
                'name' => $donorName,
                'email' => $donorEmail,
                'phone_number' => $donorPhone ?: '',
            ],
            'meta' => [
                'programme' => $programme,
                'type' => $confirmedType,
            ],
        ]);

        return gale()->state('paymentConfig', $paymentConfig);
    }

    private function initRecurringPayment(
        string $txRef,
        string $donorName,
        string $donorEmail,
        string $donorPhone,
        string $donorCountry,
        float $amount,
        string $frequency,
        string $programme
    ): mixed {
        $flwFrequency = $frequency === 'yearly' ? 'yearly' : 'monthly';
        $planName = 'BREE Recurring - '.$flwFrequency.' - '.$donorEmail;
        $planId = null;

        try {
            $planResponse = Http::withToken(config('flutterwave.secretKey'))
                ->post('https://api.flutterwave.com/v3/payment-plans', [
                    'amount' => $amount,
                    'name' => $planName,
                    'interval' => $flwFrequency,
                    'currency' => 'EUR',
                    'duration' => 0,
                ]);

            if ($planResponse->successful() && ($planResponse->json('status') === 'success')) {
                $planId = (string) $planResponse->json('data.id');
            } else {
                Log::channel('flutterwave')->warning('Payment plan creation failed', [
                    'response' => $planResponse->json(),
                    'donor' => $donorEmail,
                ]);
            }
        } catch (\Throwable $e) {
            Log::channel('flutterwave')->error('Payment plan API error: '.$e->getMessage());
        }

        RecurringDonation::create([
            'tx_ref' => $txRef,
            'flutterwave_plan_id' => $planId,
            'amount' => $amount,
            'currency' => 'EUR',
            'frequency' => $frequency,
            'programme' => $programme,
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,
            'donor_phone' => $donorPhone ?: null,
            'donor_country' => strtoupper($donorCountry) ?: 'CM',
            'status' => 'pending',
        ]);

        $modalData = [
            'tx_ref' => $txRef,
            'amount' => $amount,
            'currency' => 'EUR',
            'customer' => [
                'name' => $donorName,
                'email' => $donorEmail,
                'phone_number' => $donorPhone ?: '',
            ],
            'meta' => [
                'programme' => $programme,
                'type' => 'recurring',
                'frequency' => $frequency,
            ],
        ];

        if ($planId) {
            $modalData['payment_plan'] = (int) $planId;
        }

        $paymentConfig = Flutterwave::render('inline', $modalData);

        return gale()->state('paymentConfig', $paymentConfig);
    }

    public function successPage(Request $request): mixed
    {
        $txRef = $request->input('tx_ref');
        $donation = $txRef ? Donation::where('tx_ref', $txRef)->first() : null;

        $programmeLabel = null;
        if ($donation) {
            $programmeMap = [
                'bree-protege' => __('donation.programme_protege'),
                'bree-eleve' => __('donation.programme_eleve'),
                'bree-respire' => __('donation.programme_respire'),
                'general' => __('donation.programme_general'),
            ];
            $programmeLabel = $programmeMap[$donation->programme] ?? __('donation.programme_general');
        }

        return gale()->view('public.donation.merci', compact('donation', 'programmeLabel'), web: true);
    }
}
