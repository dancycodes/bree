<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use App\Models\FoundationEvent;
use App\Models\ProgramCard;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(): mixed
    {
        $upcoming = FoundationEvent::upcoming()->get();
        $past = FoundationEvent::past()->get();

        return gale()->view('public.events.index', compact('upcoming', 'past'), web: true);
    }

    public function show(FoundationEvent $event): mixed
    {
        if (! $event->is_published) {
            abort(404);
        }

        $isPast = $event->event_date->isPast();
        $isFull = $event->isFull();
        $program = $event->program_slug
            ? ProgramCard::where('slug', $event->program_slug)->first()
            : null;

        return gale()->view('public.events.show', compact('event', 'isPast', 'isFull', 'program'), web: true);
    }

    public function register(Request $request, FoundationEvent $event): mixed
    {
        if (! $event->is_published || ! $event->registration_required || $event->event_date->isPast() || $event->isFull()) {
            abort(404);
        }

        $validated = $request->validateState([
            'reg_name' => 'required|string|max:255',
            'reg_email' => 'required|email|max:255',
        ]);

        $alreadyRegistered = EventRegistration::where('event_id', $event->id)
            ->where('email', $validated['reg_email'])
            ->exists();

        if ($alreadyRegistered) {
            return gale()->dispatch('toast', [
                'message' => __('events.already_registered'),
                'type' => 'warning',
            ]);
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'name' => $validated['reg_name'],
            'email' => $validated['reg_email'],
        ]);

        return gale()
            ->state('reg_name', '')
            ->state('reg_email', '')
            ->dispatch('toast', [
                'message' => __('events.registration_success'),
                'type' => 'success',
            ]);
    }
}
