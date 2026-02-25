<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $hero = HeroSection::active();

        return gale()->view('public.home', compact('hero'), web: true);
    }
}
