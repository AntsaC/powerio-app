<?php

namespace App\Services\AI;

use App\Contracts\AgentIAInterface;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIAgent implements AgentIAInterface
{
    

    public function __construct(
        private string $model = ''
    )
    {
        $this->model = $model ?: config('services.openai.model', 'gpt-4-1-mini');
    }

    public function sendMessage(string $message, array $context = []): string
    {
        $response = OpenAI::responses()->create([
            'input' => $message,
            'model' => $this->model,
        ]);
        return $response->outputText;
    }

    public function sendMessageWithJsonOutput(string $message, array $jsonSchema = []): array
    {
        $schemaName = $jsonSchema['name'] ?? 'response_schema';

        $response = OpenAI::responses()->create([
            'input' => $message,
            'model' => $this->model,
            'text' => [
                'format' => [
                    'type' => 'json_schema',
                    'name' => $schemaName,
                    'schema' => $jsonSchema['schema']
                ]
            ]
        ]);
        $jsonOutput = json_decode($response->outputText, true);
        return $jsonOutput;
    }

    /**
     * {@inheritDoc}
     */
    public function getAgentName(): string
    {
        return 'OpenAI (' . $this->model . ')';
    }

}
