<?php

namespace App\Mail;

use App\Models\InKindDonation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InKindAdminNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly InKindDonation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[BREE] Nouveau don en nature — '.$this->donation->donor_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inkind-admin-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
