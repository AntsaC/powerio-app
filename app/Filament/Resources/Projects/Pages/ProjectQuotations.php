<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Quotation;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

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
        $quotation = Quotation::findOrFail($quotationId);

        if ($quotation->project_id !== $this->record->id) {
            Notification::make()
                ->title('Unauthorized access')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Email functionality coming soon')
            ->body('The email feature will be implemented in the next update.')
            ->info()
            ->send();
    }
}
