<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $amount;
    public $reference;
    public $logo;
    public $pdfContent;
    public $pdfFilename;

    public function __construct($name, $amount, $reference, $pdfContent, $pdfFilename = 'Transaction_Receipt.pdf')
    {
        $this->name = $name;
        $this->amount = $amount;
        $this->reference = $reference;
        $this->logo = asset('images/logo.png'); // Ensure the image is publicly accessible
        $this->pdfContent = $pdfContent;
        $this->pdfFilename = $pdfFilename;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Transaction Receipt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.member.transaction_receipt',
            with: [
                'name' => $this->name,
                'amount' => $this->amount,
                'reference' => $this->reference,
                'logo' => $this->logo
            ],
        );
    }

    public function build()
    {
        return $this->attachData($this->pdfContent, $this->pdfFilename, [
            'mime' => 'application/pdf',
        ]);
    }
}
