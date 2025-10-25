<?php

namespace Tests\Feature\Services\Project;

use App\Models\Project;
use App\Services\Project\ProjectSunshineHourGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectSunshineHourGeneratorTest extends TestCase
{
    use RefreshDatabase;

    private ProjectSunshineHourGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = app(ProjectSunshineHourGenerator::class);
    }

    public function test_generate_returns_valid_sunshine_hours_dto(): void
    {
        $project = Project::factory()->create([
            'name' => 'Test Solar Project',
            'location' => 'Paris, France',
            'latitude' => 48.8566,
            'longitude' => 2.3522,
        ]);

        $result = $this->generator->generate($project);

        $this->assertInstanceOf(\App\DTO\SunshineHoursDTO::class, $result);
        $this->assertGreaterThanOrEqual(0, $result->startSunshineHours);
        $this->assertLessThanOrEqual(24, $result->startSunshineHours);
        $this->assertGreaterThanOrEqual(0, $result->endSunshineHours);
        $this->assertLessThanOrEqual(24, $result->endSunshineHours);
        $this->assertLessThanOrEqual($result->endSunshineHours, $result->startSunshineHours);
    }

}
