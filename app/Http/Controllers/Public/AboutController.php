<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationMilestone;

class AboutController extends Controller
{
    public function index(): mixed
    {
        $milestones = FoundationMilestone::active()->get();

        return gale()->view('public.about.index', compact('milestones'), web: true);
    }
}
