<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundationEvent;

class EventsController extends Controller
{
    public function index(): mixed
    {
        $upcoming = FoundationEvent::upcoming()->get();
        $past = FoundationEvent::past()->get();

        return gale()->view('public.events.index', compact('upcoming', 'past'), web: true);
    }
}
