<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BotConfigurationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $botConfig;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $botConfig)
    {
        $this->user = $user;
        $this->botConfig = $botConfig;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Bot Configuration Is Being Connected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.bot',
            with: [
                'user' => $this->user,
                'botConfig' => $this->botConfig,
            ]
        );
    }
    

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
