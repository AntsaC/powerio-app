<?php

namespace App\Contracts;

interface AgentIAInterface
{

    public function sendMessage(string $message, array $context = []): string;

    public function sendMessageWithJsonOutput(string $message, array $jsonSchema = []): array;

    /**
     * Get the agent name/identifier.
     *
     * @return string The agent name
     */
    public function getAgentName(): string;
}
