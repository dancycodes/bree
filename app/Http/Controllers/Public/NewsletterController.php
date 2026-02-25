<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): mixed
    {
        $validated = $request->validateState([
            'newsletter_email' => 'required|email|max:255',
        ]);

        // BR-001: Silently accept duplicate emails (no duplicate created, show success)
        NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['newsletter_email']],
            ['locale' => app()->getLocale()]
        );

        return gale()->dispatch('toast', [
            'message' => __('home.newsletter_success'),
            'type' => 'success',
        ])->state('newsletter_email', '');
    }
}
