<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Services\Project\ProjectSunshineHourGenerator;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ProjectDetail extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.project-detail';

    public bool $isGenerating = false;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function generateSunshineHours(): void
    {
        $this->isGenerating = true;

        try {
            $generator = app(ProjectSunshineHourGenerator::class);
            $sunshineHours = $generator->generate($this->record);

            $this->record->update([
                'start_sunshine_hours' => $sunshineHours->startSunshineHours,
                'end_sunshine_hours' => $sunshineHours->endSunshineHours,
            ]);

            $this->record->refresh();

            Notification::make()
                ->success()
                ->title('Sunshine hours generated successfully')
                ->body("Start: {$sunshineHours->startSunshineHours}h, End: {$sunshineHours->endSunshineHours}h")
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Failed to generate sunshine hours')
                ->body($e->getMessage())
                ->send();
        } finally {
            $this->isGenerating = false;
        }
    }
}
