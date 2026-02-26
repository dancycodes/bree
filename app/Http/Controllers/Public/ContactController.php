<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactAdminNotification;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(): mixed
    {
        $siteSettings = SiteSetting::allSettings();

        return gale()->view('public.contact.index', compact('siteSettings'), web: true);
    }

    public function store(Request $request): mixed
    {
        $validated = $request->validateState([
            'contactName' => ['required', 'string', 'max:150'],
            'contactEmail' => ['required', 'email', 'max:255'],
            'contactSubject' => ['required', 'string', 'max:255'],
            'contactMessage' => ['required', 'string', 'max:5000'],
        ], [
            'contactName.required' => __('contact.form_name_required'),
            'contactEmail.required' => __('contact.form_email_invalid'),
            'contactEmail.email' => __('contact.form_email_invalid'),
            'contactSubject.required' => __('contact.form_subject_required'),
            'contactMessage.required' => __('contact.form_message_required'),
            'contactMessage.max' => __('contact.form_message_max'),
        ]);

        $message = ContactMessage::create([
            'name' => $validated['contactName'],
            'email' => $validated['contactEmail'],
            'subject' => $validated['contactSubject'],
            'message' => $validated['contactMessage'],
        ]);

        try {
            Mail::to(config('mail.from.address'))
                ->queue(new ContactAdminNotification($message));
        } catch (\Throwable $e) {
            Log::error('Failed to queue contact admin notification: '.$e->getMessage(), [
                'contact_message_id' => $message->id,
            ]);
        }

        return gale()
            ->state('contactSubmitted', true)
            ->state('contactName', '')
            ->state('contactEmail', '')
            ->state('contactSubject', '')
            ->state('contactMessage', '')
            ->dispatch('toast', ['message' => __('contact.form_success_toast'), 'type' => 'success']);
    }
}
