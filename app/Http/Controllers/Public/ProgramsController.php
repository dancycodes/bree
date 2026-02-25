<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProgramCard;

class ProgramsController extends Controller
{
    public function index(): mixed
    {
        $programs = ProgramCard::active()->get();

        return gale()->view('public.programs.index', compact('programs'), web: true);
    }
}
