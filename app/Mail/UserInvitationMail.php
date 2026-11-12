<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\UserInvite;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    public function __construct(UserInvite $invite)
    {
        $this->invite = $invite;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'You have been invited to join The Grapes');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invite',
            with: [
                'inviteUrl' => route('register.invite', ['token' => $this->invite->token])
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
