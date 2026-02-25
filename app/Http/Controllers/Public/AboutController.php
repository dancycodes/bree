<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationMilestone;
use App\Models\FounderProfile;
use App\Models\PatronProfile;

class AboutController extends Controller
{
    public function index(): mixed
    {
        $milestones = FoundationMilestone::active()->get();
        $founder = FounderProfile::active();
        $patron = PatronProfile::active();

        return gale()->view('public.about.index', compact('milestones', 'founder', 'patron'), web: true);
    }
}
