<?php

namespace App\Mail;

use App\Models\Quotation;
use App\Services\QuotationPDFGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Quotation $quotation
    ) {}

    public function envelope(): Envelope
    {
        $quotationNumber = $this->quotation->quotation_number ?? $this->quotation->id;

        return new Envelope(
            subject: "Quotation #{$quotationNumber} - {$this->quotation->project->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quotation',
        );
    }

    public function attachments(): array
    {
        $generator = new QuotationPDFGenerator();
        $pdf = $generator->generate($this->quotation);

        $filename = $generator->generateFilename($this->quotation);

        return [
            Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf'),
        ];
    }
}
