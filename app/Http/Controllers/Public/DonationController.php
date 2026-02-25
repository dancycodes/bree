<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ImpactExample;
use Illuminate\Http\Request;

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
            ->state('amountConfirmed', false);
    }

    public function validateAmount(Request $request): mixed
    {
        $showCustom = (bool) $request->state('showCustom', false);
        $type = $request->state('donationType', 'direct');

        if ($showCustom) {
            $rawAmount = (string) $request->state('customAmount', '');
            $amount = (float) str_replace(',', '.', $rawAmount);

            if (! is_numeric(str_replace(',', '.', $rawAmount)) || $amount <= 0) {
                return gale()->messages(['amount' => [__('donation.amount_error_numeric')]]);
            }
        } else {
            $amount = (float) $request->state('selectedAmount', 0);
        }

        if ($amount < 1) {
            return gale()->messages(['amount' => [__('donation.amount_error_min')]]);
        }

        return gale()
            ->state('amountConfirmed', true)
            ->state('confirmedAmount', $amount)
            ->state('confirmedType', $type);
    }
}
