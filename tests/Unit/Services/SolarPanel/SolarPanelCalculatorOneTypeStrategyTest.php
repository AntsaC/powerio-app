<?php

namespace Tests\Unit\Services\SolarPanel;

use App\Contracts\SolarPanelRepositoryInterface;
use App\DTO\SolarPanelCalculationDTO;
use App\DTO\SolarPanelItemDTO;
use App\Models\Project;
use App\Models\SolarPanel;
use App\Repositories\SolarPanelRepository;
use App\Services\SolarPanel\SolarPanelCalculatorOneTypeStrategy;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class SolarPanelCalculatorOneTypeStrategyTest extends TestCase
{
    private SolarPanelCalculatorOneTypeStrategy $calculator;

    protected function setUp(): void
    {
        parent::setUp();

        // Create 3 real solar panel instances with varying specifications
        $panel1 = new SolarPanel([
            'name' => 'Standard Panel 300W',
            'manufacturer' => 'SolarTech',
            'model' => 'ST-300',
            'nominal_power' => 300, // 300W
            'efficiency' => 18.5,
            'price' => 150.00,
        ]);
        $panel1->id = 1;

        $panel2 = new SolarPanel([
            'name' => 'Premium Panel 400W',
            'manufacturer' => 'SunPower',
            'model' => 'SP-400',
            'nominal_power' => 400, // 400W
            'efficiency' => 21.0,
            'price' => 200.00,
        ]);
        $panel2->id = 2;

        $panel3 = new SolarPanel([
            'name' => 'High Efficiency Panel 500W',
            'manufacturer' => 'MaxSolar',
            'model' => 'MS-500',
            'nominal_power' => 500, // 500W
            'efficiency' => 23.5,
            'price' => 300.00,
        ]);
        $panel3->id = 3;

        $collection = new Collection([$panel3, $panel2, $panel1]);

        $this->mock(SolarPanelRepository::class, function ($mock) use ($collection) {
            $mock->shouldReceive('getAllOrderedByNominalPower')
                ->byDefault()
                ->andReturn($collection);
        });

        $this->calculator = app(SolarPanelCalculatorOneTypeStrategy::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_generate_solarpanel_calculation_and_returns_suitable(): void
    {
        $project = new Project([
            'system_capacity' => 3.0, // 3kW
            'start_sunshine_hours' => 7,
            'end_sunshine_hours' => 19,
        ]);

        $result = $this->calculator->calculate($project);

        $this->assertInstanceOf(SolarPanelCalculationDTO::class, $result);
        $this->assertCount(1, $result->solarPanels);
        $this->assertEquals(1, $result->solarPanels[0]->solarPanel->id);
    }
}
