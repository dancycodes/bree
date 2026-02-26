<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\PartnershipApplicationNotification;
use App\Models\Partner;
use App\Models\PartnershipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PartnersController extends Controller
{
    public function index(): mixed
    {
        $partners = Partner::published()->get()->groupBy('type');

        return gale()->view('public.partners.index', compact('partners'), web: true);
    }

    public function storePartnership(Request $request): mixed
    {
        $validated = $request->validateState([
            'orgName' => 'required|string|max:255',
            'contactName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'partnershipType' => 'required|in:financial,technical,institutional,other',
            'motivation' => 'required|string|max:5000',
        ]);

        $application = PartnershipApplication::create([
            'organization_name' => $validated['orgName'],
            'contact_name' => $validated['contactName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'organization_type' => $validated['partnershipType'],
            'proposal' => $validated['motivation'],
        ]);

        Mail::to(config('mail.from.address'))->queue(new PartnershipApplicationNotification($application));

        return gale()
            ->state('partnershipSubmitted', true)
            ->state('orgName', '')->state('contactName', '')->state('email', '')
            ->state('phone', '')->state('partnershipType', '')->state('motivation', '')
            ->dispatch('toast', ['message' => 'Votre demande de partenariat a été soumise. Nous vous répondrons dans les meilleurs délais.', 'type' => 'success']);
    }
}
