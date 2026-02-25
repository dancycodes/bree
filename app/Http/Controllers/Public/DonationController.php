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
}
