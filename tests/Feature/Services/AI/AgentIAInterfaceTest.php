<?php

namespace Tests\Feature\Services\AI;

use App\Contracts\AgentIAInterface;
use App\Services\AI\AgentIAService;
use App\Services\AI\OpenAIAgent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentIAInterfaceTest extends TestCase
{
    private AgentIAInterface $agent;
    private AgentIAService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Get the agent from container
        $this->agent = app(AgentIAInterface::class);
    }

    public function test_agent_interface_is_bound_to_openai_implementation(): void
    {
        $this->assertInstanceOf(OpenAIAgent::class, $this->agent);
    }

    public function test_agent_has_valid_name(): void
    {
        $agentName = $this->agent->getAgentName();

        $this->assertNotEmpty($agentName);
        $this->assertIsString($agentName);
        $this->assertStringContainsString('OpenAI', $agentName);
    }

    public function test_send_message_returns_string_response(): void
    {
        // Skip if OpenAI API key is not configured
        if (empty(config('services.openai.api_key'))) {
            $this->markTestSkipped('OpenAI API key is not configured');
        }

        $message = 'Say "Hello World" and nothing else.';

        $response = $this->agent->sendMessage($message);

        $this->assertIsString($response);
        $this->assertNotEmpty($response);
    }

    public function test_send_message_with_json_output(): void
    {
        // Skip if OpenAI API key is not configured
        if (empty(config('services.openai.api_key'))) {
            $this->markTestSkipped('OpenAI API key is not configured');
        }

        $message = 'Create a JSON object with a user named "John Doe" aged 30.';
        $jsonSchema = [
            'name' => 'user_info',
            'strict' => true,
            'schema' => [
                'type' => 'object',
                'properties' => [
                    'name' => [
                        'type' => 'string',
                        'description' => 'The user\'s full name',
                    ],
                    'age' => [
                        'type' => 'number',
                        'description' => 'The user\'s age',
                    ],
                ],
                'required' => ['name', 'age'],
                'additionalProperties' => false,
            ],
        ];

        $response = $this->agent->sendMessageWithJsonOutput($message, $jsonSchema);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('age', $response);
        $this->assertEquals('John Doe', $response['name']);
        $this->assertEquals(30, $response['age']);
    }

}
