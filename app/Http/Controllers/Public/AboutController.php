<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationMilestone;
use App\Models\FounderProfile;
use App\Models\PatronProfile;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index(): mixed
    {
        $milestones = FoundationMilestone::active()->get();
        $founder = FounderProfile::active();
        $patron = PatronProfile::active();
        $teamMembers = TeamMember::published()->get();

        return gale()->view('public.about.index', compact('milestones', 'founder', 'patron', 'teamMembers'), web: true);
    }
}
