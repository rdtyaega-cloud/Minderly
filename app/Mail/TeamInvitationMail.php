<?php

namespace App\Mail;

use App\Models\Pengguna;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Team $team,
        public Pengguna $inviter,
        public string $inviteUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan bergabung ke tim ' . $this->team->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.teams.invitation',
        );
    }
}