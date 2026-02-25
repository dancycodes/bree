<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\MissionSection;
use App\Models\ProgramCard;
use App\Models\StatCounter;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $hero = HeroSection::active();
        $counters = StatCounter::active()->get();
        $mission = MissionSection::active();
        $programs = ProgramCard::active()->get();

        return gale()->view('public.home', compact('hero', 'counters', 'mission', 'programs'), web: true);
    }
}
