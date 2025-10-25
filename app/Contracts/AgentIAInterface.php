<?php

namespace App\Contracts;

interface AgentIAInterface
{

    public function sendMessage(string $message, array $context = []): string;

    public function sendMessageWithJsonOutput(string $message, array $jsonSchema = []): array;

    public function getAgentName(): string;
}
