<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\VolunteerApplicationNotification;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VolunteerController extends Controller
{
    public function index(): mixed
    {
        return gale()->view('public.volunteers.index', [], web: true);
    }

    public function store(Request $request): mixed
    {
        $validated = $request->validateState([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'cityCountry' => 'nullable|string|max:150',
            'areas' => 'required|array|min:1',
            'areas.*' => 'in:protege,eleve,respire',
            'availability' => 'required|in:weekends,weekdays,flexible',
            'motivation' => 'nullable|string|max:2000',
        ]);

        $application = VolunteerApplication::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'city_country' => $validated['cityCountry'] ?? null,
            'areas_of_interest' => $validated['areas'],
            'availability' => $validated['availability'],
            'motivation' => $validated['motivation'] ?? null,
        ]);

        Mail::to(config('mail.from.address'))
            ->queue(new VolunteerApplicationNotification($application));

        return gale()
            ->state('submitted', true)
            ->state('firstName', '')
            ->state('lastName', '')
            ->state('email', '')
            ->state('phone', '')
            ->state('cityCountry', '')
            ->state('areas', [])
            ->state('availability', 'flexible')
            ->state('motivation', '')
            ->dispatch('toast', ['message' => 'Votre candidature a été reçue ! Nous vous contacterons bientôt.', 'type' => 'success']);
    }
}
