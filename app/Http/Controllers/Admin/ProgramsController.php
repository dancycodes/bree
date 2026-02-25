<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCard;

class ProgramsController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('programs.view');

        $programs = ProgramCard::active()->withCount('programActivities')->get();

        return gale()->view('admin.programs.index', compact('programs'), web: true);
    }
}
