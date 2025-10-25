<?php

namespace App\Services\Project;

use App\Models\Project;

class ProjectPromptBuilder
{

    public function buildSunshineHoursPrompt(Project $project): string
    {
        $location = $project->location;
        $coordinates = $this->formatCoordinates($project);

        return "Based on the location: {$location}{$coordinates}, provide approximate start and end times of the period when sunlight is at its maximum during the day for this location.";
    }

    public function buildSunshineHoursSchema(): array
    {
        return [
            'name' => 'sunshine_hours_response',
            'schema' => [
                'type' => 'object',
                'properties' => [
                    'start_sunshine_hours' => [
                        'type' => 'number',
                        'description' => 'Start sunshine hours'
                    ],
                    'end_sunshine_hours' => [
                        'type' => 'number',
                        'description' => 'End daily sunshine hours'
                    ]
                ],
                'required' => ['start_sunshine_hours', 'end_sunshine_hours'],
                'additionalProperties' => false,
            ],
        ];
    }

    private function formatCoordinates(Project $project): string
    {
        if ($project->latitude && $project->longitude) {
            return " (Latitude: {$project->latitude}, Longitude: {$project->longitude})";
        }

        return '';
    }
}
