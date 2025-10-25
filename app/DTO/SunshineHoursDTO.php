<?php

namespace App\DTO;

class SunshineHoursDTO
{
    public function __construct(
        public readonly int $startSunshineHours,
        public readonly int $endSunshineHours
    ) {
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['start_sunshine_hours']) || !isset($data['end_sunshine_hours'])) {
            throw new \InvalidArgumentException('Missing required sunshine hour fields');
        }

        return new self(
            startSunshineHours: (float) $data['start_sunshine_hours'],
            endSunshineHours: (float) $data['end_sunshine_hours']
        );
    }

    public function toArray(): array
    {
        return [
            'min_sunshine_hours' => $this->startSunshineHours,
            'max_sunshine_hours' => $this->endSunshineHours
        ];
    }

}
