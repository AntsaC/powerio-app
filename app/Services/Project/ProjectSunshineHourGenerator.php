<?php

namespace App\Services\Project;

use App\Contracts\AgentIAInterface;
use App\DTO\SunshineHoursDTO;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectSunshineHourGenerator
{
    public function __construct(
        private AgentIAInterface $aiAgent,
        private ProjectPromptBuilder $promptBuilder
    ) {
    }

    /**
     * Generate sunshine hours for a project based on location.
     *
     * @param Project $project
     * @return SunshineHoursDTO
     * @throws \Exception
     */
    public function generate(Project $project): SunshineHoursDTO
    {
        if (empty($project->location)) {
            throw new \InvalidArgumentException('Project must have a location to generate sunshine hours');
        }

        $prompt = $this->promptBuilder->buildSunshineHoursPrompt($project);
        $jsonSchema = $this->promptBuilder->buildSunshineHoursSchema();
        
        Log::info('Generating sunshine hours for project', [
            'project_id' => $project->id,
            'location' => $project->location,
        ]);

        try {
            $response = $this->aiAgent->sendMessageWithJsonOutput($prompt, $jsonSchema);

            $dto = SunshineHoursDTO::fromArray($response);
            return $dto;
        } catch (\Exception $e) {
            Log::error('Failed to generate sunshine hours', [
                'project_id' => $project->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
