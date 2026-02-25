<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationMilestone;
use App\Models\FounderProfile;

class AboutController extends Controller
{
    public function index(): mixed
    {
        $milestones = FoundationMilestone::active()->get();
        $founder = FounderProfile::active();

        return gale()->view('public.about.index', compact('milestones', 'founder'), web: true);
    }
}
