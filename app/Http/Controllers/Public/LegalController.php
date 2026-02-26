<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class LegalController extends Controller
{
    public function mentions(): mixed
    {
        return gale()->view('public.legal.mentions', [], web: true);
    }

    public function privacy(): mixed
    {
        return gale()->view('public.legal.privacy', [], web: true);
    }
}
