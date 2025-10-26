<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Quotation;
use App\Services\QuotationEmailSender;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ProjectQuotations extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.project-quotations';

    private QuotationEmailSender $quotationEmailSender;

    public function mount(QuotationEmailSender $quotationEmailSender, int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->quotationEmailSender = $quotationEmailSender;
    }

    public function getQuotations()
    {
        return $this->record->quotations()
            ->with('lines')
            ->orderBy('quotation_date', 'desc')
            ->get();
    }

    public function sendEmail(int $quotationId): void
    {
        $quotation = Quotation::with(['project.customer'])->findOrFail($quotationId);

        $validation = $this->quotationEmailSender->validateRecipient($quotation);

        if (!$validation['valid']) {
            Notification::make()
                ->title('Cannot send email')
                ->body($validation['message'])
                ->warning()
                ->send();

            return;
        }

        try {
            $this->quotationEmailSender->sendToCustomer($quotation);

            Notification::make()
                ->title('Email sent successfully')
                ->body("Quotation has been sent to {$validation['email']}")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Email sending failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
