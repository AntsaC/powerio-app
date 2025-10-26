<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Mail\QuotationMail;
use App\Models\Quotation;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Mail;

class ProjectQuotations extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.project-quotations';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
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

        if (!$quotation->project->customer || !$quotation->project->customer->email) {
            Notification::make()
                ->title('No customer email')
                ->body('This quotation does not have a customer email address.')
                ->warning()
                ->send();

            return;
        }

        try {
            Mail::to($quotation->project->customer->email)
                ->send(new QuotationMail($quotation));

            Notification::make()
                ->title('Email sent successfully')
                ->body("Quotation has been sent to {$quotation->project->customer->email}")
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
