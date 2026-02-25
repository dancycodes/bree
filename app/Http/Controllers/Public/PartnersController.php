<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Partner;

class PartnersController extends Controller
{
    public function index(): mixed
    {
        $partners = Partner::published()->get()->groupBy('type');

        return gale()->view('public.partners.index', compact('partners'), web: true);
    }
}
