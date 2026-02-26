<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationEvent;
use App\Models\ProgramCard;

class ProgramsController extends Controller
{
    public function index(): mixed
    {
        $programs = ProgramCard::active()->with('programActivities')->get();

        return gale()->view('public.programs.index', compact('programs'), web: true);
    }

    public function show(ProgramCard $program): mixed
    {
        $program->load(['programActivities', 'stories' => fn ($q) => $q->published()]);
        $otherPrograms = ProgramCard::active()->with('programActivities')->where('slug', '!=', $program->slug)->get();
        $programEvents = FoundationEvent::upcoming()->where('program_slug', $program->slug)->limit(3)->get();

        return gale()->view('public.programs.show', compact('program', 'otherPrograms', 'programEvents'), web: true);
    }
}
