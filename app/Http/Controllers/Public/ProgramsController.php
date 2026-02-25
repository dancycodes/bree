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

    public function show(ProgramCard $program): mixed
    {
        $otherPrograms = ProgramCard::active()->where('slug', '!=', $program->slug)->get();

        return gale()->view('public.programs.show', compact('program', 'otherPrograms'), web: true);
    }
}
