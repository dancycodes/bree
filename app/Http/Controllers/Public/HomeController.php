<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\MissionSection;
use App\Models\StatCounter;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $hero = HeroSection::active();
        $counters = StatCounter::active()->get();
        $mission = MissionSection::active();

        return gale()->view('public.home', compact('hero', 'counters', 'mission'), web: true);
    }
}
