<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\StatCounter;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $hero = HeroSection::active();
        $counters = StatCounter::active()->get();

        return gale()->view('public.home', compact('hero', 'counters'), web: true);
    }
}
