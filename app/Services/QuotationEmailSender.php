<?php

namespace App\Services;

use App\Mail\QuotationMail;
use App\Models\Quotation;
use Illuminate\Support\Facades\Mail;

class QuotationEmailSender
{
    public function send(Quotation $quotation, ?string $email = null): bool
    {
        $recipientEmail = $this->getRecipientEmail($quotation, $email);

        if (!$recipientEmail) {
            throw new \Exception('No recipient email address available.');
        }

        $this->loadRelations($quotation);

        Mail::to($recipientEmail)->send(new QuotationMail($quotation));

        return true;
    }

    public function sendToCustomer(Quotation $quotation): bool
    {
        return $this->send($quotation);
    }

    public function sendToEmail(Quotation $quotation, string $email): bool
    {
        return $this->send($quotation, $email);
    }

    protected function getRecipientEmail(Quotation $quotation, ?string $email = null): ?string
    {
        if ($email) {
            return $email;
        }

        if ($quotation->project && $quotation->project->customer) {
            return $quotation->project->customer->email;
        }

        return null;
    }

    protected function loadRelations(Quotation $quotation): void
    {
        if (!$quotation->relationLoaded('project')) {
            $quotation->load('project.customer');
        }

        if ($quotation->relationLoaded('project') && !$quotation->project->relationLoaded('customer')) {
            $quotation->project->load('customer');
        }
    }

    public function validateRecipient(Quotation $quotation, ?string $email = null): array
    {
        $recipientEmail = $this->getRecipientEmail($quotation, $email);

        if (!$recipientEmail) {
            return [
                'valid' => false,
                'message' => 'No recipient email address available.',
                'email' => null,
            ];
        }

        if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            return [
                'valid' => false,
                'message' => 'Invalid email address format.',
                'email' => $recipientEmail,
            ];
        }

        return [
            'valid' => true,
            'message' => 'Valid recipient email.',
            'email' => $recipientEmail,
        ];
    }
}
