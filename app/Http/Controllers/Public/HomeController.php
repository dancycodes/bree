<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(): mixed
    {
        return gale()->view('public.home', [], web: true);
    }
}
