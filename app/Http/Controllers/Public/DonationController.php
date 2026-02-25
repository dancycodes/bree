<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\DonationConfirmation;
use App\Mail\InKindAdminNotification;
use App\Mail\PledgeAdminNotification;
use App\Models\Donation;
use App\Models\DonationPledge;
use App\Models\ImpactExample;
use App\Models\InKindDonation;
use App\Models\RecurringDonation;
use App\Services\FlutterwaveDirectCharge;
use Flutterwave\Payments\Facades\Flutterwave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        return gale()->state('cardStep', true)->state('txRef', $txRef);
    }

    public function chargeCard(Request $request): mixed
    {
        $txRef = (string) $request->state('txRef', '');
        $cardNumber = preg_replace('/\D/', '', (string) $request->state('cardNumber', ''));
        $cardExpiry = (string) $request->state('cardExpiry', '');
        $cardCvv = preg_replace('/\D/', '', (string) $request->state('cardCvv', ''));
        $confirmedType = (string) $request->state('confirmedType', 'direct');

        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            return gale()->messages(['cardNumber' => [__('donation.card_number_invalid')]]);
        }

        if (! preg_match('/^(\d{2})[\/\-]?(\d{2,4})$/', str_replace(' ', '', $cardExpiry), $m)) {
            return gale()->messages(['cardExpiry' => [__('donation.card_expiry_invalid')]]);
        }

        $expiryMonth = $m[1];
        $expiryYear = strlen($m[2]) === 2 ? '20'.$m[2] : $m[2];

        if (strlen($cardCvv) < 3 || strlen($cardCvv) > 4) {
            return gale()->messages(['cardCvv' => [__('donation.card_cvv_invalid')]]);
        }

        if (empty($txRef)) {
            return gale()->messages(['cardNumber' => [__('donation.payment_error_generic')]]);
        }

        $isRecurring = $confirmedType === 'recurring';
        $donation = $isRecurring
            ? RecurringDonation::where('tx_ref', $txRef)->first()
            : Donation::where('tx_ref', $txRef)->first();

        if (! $donation) {
            return gale()->messages(['cardNumber' => [__('donation.payment_error_generic')]]);
        }

        if (! $isRecurring && $donation->isCompleted()) {
            return gale()->redirect(route('public.donate.merci', ['tx_ref' => $txRef]));
        }

        $payload = [
            'card_number' => $cardNumber,
            'cvv' => $cardCvv,
            'expiry_month' => $expiryMonth,
            'expiry_year' => $expiryYear,
            'currency' => $donation->currency,
            'amount' => (float) $donation->amount,
            'fullname' => $donation->donor_name,
            'email' => $donation->donor_email,
            'phone_number' => $donation->donor_phone ?? '',
            'tx_ref' => $txRef,
            'redirect_url' => route('public.donate.verify3ds'),
            'meta' => [
                'programme' => $donation->programme,
                'type' => $confirmedType,
            ],
        ];

        if ($isRecurring && $donation->flutterwave_plan_id) {
            $payload['payment_plan'] = (int) $donation->flutterwave_plan_id;
        }

        $service = new FlutterwaveDirectCharge(config('flutterwave.secretKey'));
        session(['flw_payload_'.md5($txRef) => $payload]);

        $result = $service->charge($payload);

        return $this->handleChargeResponse($result, $txRef, $isRecurring);
    }

    public function authenticateCharge(Request $request): mixed
    {
        $authMode = (string) $request->state('authMode', '');
        $pinValue = (string) $request->state('pinValue', '');
        $otpValue = (string) $request->state('otpValue', '');
        $flwRef = (string) $request->state('flwRef', '');
        $txRef = (string) $request->state('txRef', '');
        $confirmedType = (string) $request->state('confirmedType', 'direct');
        $isRecurring = $confirmedType === 'recurring';

        $service = new FlutterwaveDirectCharge(config('flutterwave.secretKey'));

        if ($authMode === 'pin') {
            if (strlen(preg_replace('/\D/', '', $pinValue)) < 4) {
                return gale()->messages(['pinValue' => [__('donation.card_pin_invalid')]]);
            }

            $sessionKey = 'flw_payload_'.md5($txRef);
            $payload = session($sessionKey);

            if (! $payload) {
                return gale()->messages(['pinValue' => [__('donation.payment_error_generic')]]);
            }

            $payload['authorization'] = ['mode' => 'pin', 'pin' => preg_replace('/\D/', '', $pinValue)];
            session()->forget($sessionKey);

            $result = $service->charge($payload);

            return $this->handleChargeResponse($result, $txRef, $isRecurring);
        }

        if ($authMode === 'otp') {
            if (empty($otpValue)) {
                return gale()->messages(['otpValue' => [__('donation.card_otp_required')]]);
            }

            $result = $service->validateCharge($otpValue, $flwRef);

            if (($result['status'] ?? '') === 'success') {
                return $this->completeDonation($result['data'] ?? [], $txRef, $isRecurring);
            }

            Log::channel('flutterwave')->error('OTP validation failed', ['result' => $result, 'txRef' => $txRef]);

            return gale()->messages(['otpValue' => [$result['message'] ?? __('donation.payment_error_generic')]]);
        }

        return gale()->messages(['cardNumber' => [__('donation.payment_error_generic')]]);
    }

    public function verifyPayment(Request $request): mixed
    {
        $txRef = (string) $request->input('tx_ref', '');
        $transactionId = (int) $request->input('transaction_id', 0);

        if ($txRef && $transactionId) {
            $service = new FlutterwaveDirectCharge(config('flutterwave.secretKey'));
            $verification = $service->verifyTransaction($transactionId);
            $txStatus = $verification['data']['status'] ?? 'failed';
            $data = $verification['data'] ?? [];

            $donation = Donation::where('tx_ref', $txRef)->first();
            $isRecurring = false;

            if (! $donation) {
                $donation = RecurringDonation::where('tx_ref', $txRef)->first();
                $isRecurring = true;
            }

            if ($donation) {
                if ($isRecurring) {
                    $donation->update([
                        'flutterwave_subscription_id' => (string) ($data['id'] ?? ''),
                        'status' => $txStatus === 'successful' ? 'active' : 'failed',
                        'flutterwave_data' => $data ?: null,
                    ]);
                } else {
                    $newStatus = $txStatus === 'successful' ? 'completed' : 'failed';
                    $donation->update([
                        'flutterwave_id' => (string) ($data['id'] ?? ''),
                        'status' => $newStatus,
                        'flutterwave_data' => $data ?: null,
                    ]);

                    if ($newStatus === 'completed') {
                        Mail::to($donation->donor_email)->queue(new DonationConfirmation($donation));
                    }
                }
            }
        }

        return redirect()->route('public.donate.merci', array_filter(['tx_ref' => $txRef]));
    }

    public function storePledge(Request $request): mixed
    {
        $request->validateState([
            'pledgeFirstName' => ['required', 'string', 'max:100'],
            'pledgeLastName' => ['required', 'string', 'max:100'],
            'pledgeEmail' => ['required', 'email'],
            'pledgePhone' => ['nullable', 'string', 'max:30'],
            'pledgeAddress' => ['nullable', 'string', 'max:255'],
            'pledgeNature' => ['nullable', 'string', 'in:monetary,in_kind'],
            'pledgeAmount' => ['nullable', 'numeric', 'min:0'],
            'pledgeProgramme' => ['nullable', 'string', 'in:general,bree-protege,bree-eleve,bree-respire'],
            'pledgeMessage' => ['nullable', 'string', 'max:1000'],
        ], [
            'pledgeFirstName.required' => __('donation.pledge_firstname_required'),
            'pledgeLastName.required' => __('donation.pledge_lastname_required'),
            'pledgeEmail.required' => __('donation.pledge_email_invalid'),
            'pledgeEmail.email' => __('donation.pledge_email_invalid'),
            'pledgeAmount.numeric' => __('donation.pledge_amount_invalid'),
        ]);

        $nature = (string) $request->state('pledgeNature', 'monetary');
        $programme = (string) $request->state('pledgeProgramme', '');
        $rawAmount = (string) $request->state('pledgeAmount', '');

        $amount = null;
        if ($nature === 'monetary' && ! empty($rawAmount)) {
            $amount = (float) str_replace(',', '.', $rawAmount);
        }

        $validProgrammes = ['bree-protege', 'bree-eleve', 'bree-respire', 'general'];
        if (! in_array($programme, $validProgrammes, true)) {
            $programme = null;
        }

        $pledge = DonationPledge::create([
            'first_name' => (string) $request->state('pledgeFirstName'),
            'last_name' => (string) $request->state('pledgeLastName'),
            'address' => ($v = trim((string) $request->state('pledgeAddress', ''))) ? $v : null,
            'phone' => ($v = trim((string) $request->state('pledgePhone', ''))) ? $v : null,
            'email' => (string) $request->state('pledgeEmail'),
            'amount' => $amount,
            'currency' => 'EUR',
            'nature' => in_array($nature, ['monetary', 'in_kind'], true) ? $nature : 'monetary',
            'programme' => $programme,
            'message' => ($v = trim((string) $request->state('pledgeMessage', ''))) ? $v : null,
            'status' => 'pending',
        ]);

        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->queue(new PledgeAdminNotification($pledge));

        return gale()
            ->state('pledgeSubmitted', true)
            ->state('pledgeFirstName', '')
            ->state('pledgeLastName', '')
            ->state('pledgeAddress', '')
            ->state('pledgePhone', '')
            ->state('pledgeEmail', '')
            ->state('pledgeAmount', '')
            ->state('pledgeNature', 'monetary')
            ->state('pledgeProgramme', '')
            ->state('pledgeMessage', '')
            ->dispatch('toast', [
                'type' => 'success',
                'message' => __('donation.pledge_success_toast'),
            ]);
    }

    public function storeInKind(Request $request): mixed
    {
        $request->validateState([
            'inkindDonorName' => ['required', 'string', 'max:150'],
            'inkindOrganization' => ['nullable', 'string', 'max:150'],
            'inkindEmail' => ['required', 'email'],
            'inkindPhone' => ['nullable', 'string', 'max:30'],
            'inkindType' => ['required', 'string', 'in:goods,services,expertise,other'],
            'inkindDescription' => ['required', 'string', 'max:2000'],
            'inkindEstimatedValue' => ['nullable', 'numeric', 'min:0'],
            'inkindProgramme' => ['nullable', 'string', 'in:general,bree-protege,bree-eleve,bree-respire'],
            'inkindAvailability' => ['nullable', 'string', 'max:255'],
        ], [
            'inkindDonorName.required' => __('donation.inkind_name_required'),
            'inkindEmail.required' => __('donation.inkind_email_invalid'),
            'inkindEmail.email' => __('donation.inkind_email_invalid'),
            'inkindType.required' => __('donation.inkind_type_required'),
            'inkindDescription.required' => __('donation.inkind_description_required'),
            'inkindEstimatedValue.numeric' => __('donation.inkind_value_invalid'),
        ]);

        $programme = (string) $request->state('inkindProgramme', '');
        $validProgrammes = ['bree-protege', 'bree-eleve', 'bree-respire', 'general'];
        if (! in_array($programme, $validProgrammes, true)) {
            $programme = null;
        }

        $rawValue = (string) $request->state('inkindEstimatedValue', '');
        $estimatedValue = ! empty($rawValue) ? (float) str_replace(',', '.', $rawValue) : null;

        $donation = InKindDonation::create([
            'donor_name' => (string) $request->state('inkindDonorName'),
            'organization' => ($v = trim((string) $request->state('inkindOrganization', ''))) ? $v : null,
            'email' => (string) $request->state('inkindEmail'),
            'phone' => ($v = trim((string) $request->state('inkindPhone', ''))) ? $v : null,
            'donation_type' => (string) $request->state('inkindType'),
            'description' => (string) $request->state('inkindDescription'),
            'estimated_value' => $estimatedValue,
            'programme' => $programme,
            'availability' => ($v = trim((string) $request->state('inkindAvailability', ''))) ? $v : null,
            'status' => 'pending_review',
        ]);

        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->queue(new InKindAdminNotification($donation));

        return gale()
            ->state('inkindSubmitted', true)
            ->state('inkindDonorName', '')
            ->state('inkindOrganization', '')
            ->state('inkindEmail', '')
            ->state('inkindPhone', '')
            ->state('inkindType', 'goods')
            ->state('inkindDescription', '')
            ->state('inkindEstimatedValue', '')
            ->state('inkindProgramme', '')
            ->state('inkindAvailability', '')
            ->dispatch('toast', [
                'type' => 'success',
                'message' => __('donation.inkind_success_toast'),
            ]);
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

        return gale()->state('cardStep', true)->state('txRef', $txRef);
    }

    private function handleChargeResponse(array $result, string $txRef, bool $isRecurring): mixed
    {
        $status = $result['status'] ?? 'error';

        if ($status === 'error' || $status === 'failed') {
            Log::channel('flutterwave')->error('Direct charge error', ['result' => $result, 'txRef' => $txRef]);

            return gale()->messages(['cardNumber' => [$result['message'] ?? __('donation.payment_error_generic')]]);
        }

        if ($status === 'success') {
            $data = $result['data'] ?? [];
            $meta = $result['meta'] ?? [];
            $authMode = $meta['authorization']['mode'] ?? '';
            $dataStatus = $data['status'] ?? '';

            if ($dataStatus === 'successful' || $authMode === 'noauth') {
                return $this->completeDonation($data, $txRef, $isRecurring);
            }

            if ($authMode === 'pin') {
                return gale()->state('authMode', 'pin');
            }

            if ($authMode === 'otp') {
                return gale()
                    ->state('authMode', 'otp')
                    ->state('flwRef', $data['flw_ref'] ?? '');
            }

            if ($authMode === 'redirect') {
                return gale()
                    ->state('authMode', 'redirect')
                    ->state('redirectUrl', $meta['authorization']['redirect'] ?? '');
            }

            // Pending — webhook will confirm
            return $this->completeDonation($data, $txRef, $isRecurring);
        }

        return gale()->messages(['cardNumber' => [__('donation.payment_error_generic')]]);
    }

    private function completeDonation(array $transactionData, string $txRef, bool $isRecurring): mixed
    {
        if ($isRecurring) {
            $donation = RecurringDonation::where('tx_ref', $txRef)->first();

            if ($donation && ! $donation->isActive()) {
                $donation->update([
                    'flutterwave_subscription_id' => (string) ($transactionData['id'] ?? ''),
                    'status' => 'active',
                    'flutterwave_data' => $transactionData ?: null,
                ]);
            }
        } else {
            $donation = Donation::where('tx_ref', $txRef)->first();

            if ($donation && ! $donation->isCompleted()) {
                $txStatus = $transactionData['status'] ?? 'pending';
                $newStatus = $txStatus === 'successful' ? 'completed' : 'pending';

                $donation->update([
                    'flutterwave_id' => (string) ($transactionData['id'] ?? ''),
                    'status' => $newStatus,
                    'flutterwave_data' => $transactionData ?: null,
                ]);

                if ($newStatus === 'completed') {
                    Mail::to($donation->donor_email)->queue(new DonationConfirmation($donation));
                }
            }
        }

        return gale()->redirect(route('public.donate.merci', ['tx_ref' => $txRef]));
    }
}
