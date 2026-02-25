<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationEvent;
use App\Models\FounderSection;
use App\Models\HeroSection;
use App\Models\MissionSection;
use App\Models\NewsArticle;
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
        $latestNews = NewsArticle::published()->limit(3)->get();
        $founders = FounderSection::active();
        $upcomingEvents = FoundationEvent::upcoming()->limit(3)->get();

        return gale()->view('public.home', compact('hero', 'counters', 'mission', 'programs', 'latestNews', 'founders', 'upcomingEvents'), web: true);
    }
}
