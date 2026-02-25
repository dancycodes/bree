<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Donation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('donation.merci_heading_personalized', ['name' => $this->donation->donor_name]),
            replyTo: [new \Illuminate\Mail\Mailables\Address('contact@breefondation.org', config('app.name'))],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
