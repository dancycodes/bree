<?php

namespace App\Mail;

use App\Models\RecurringDonation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecurringDonationCancelled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly RecurringDonation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre don récurrent a été annulé — Fondation BREE',
            replyTo: [new \Illuminate\Mail\Mailables\Address('contact@breefondation.org', config('app.name'))],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recurring-cancelled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
