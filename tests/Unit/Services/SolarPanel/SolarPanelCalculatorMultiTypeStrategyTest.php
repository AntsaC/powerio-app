<?php

namespace Tests\Unit\Services\SolarPanel;

use App\DTO\SolarPanelCalculationDTO;
use App\DTO\SolarPanelItemDTO;
use App\Models\Project;
use App\Models\SolarPanel;
use App\Repositories\SolarPanelRepository;
use App\Services\SolarPanel\SolarPanelCalculatorMultiTypeStrategy;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class SolarPanelCalculatorMultiTypeStrategyTest extends TestCase
{
    private SolarPanelCalculatorMultiTypeStrategy $calculator;

    protected function setUp(): void
    {
        parent::setUp();

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
            $mock->shouldReceive('getAllOrderedByCapacity')
                ->byDefault()
                ->andReturn($collection);
        });

        $this->calculator = app(SolarPanelCalculatorMultiTypeStrategy::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_calculate_returns_multiple_panel_types_for_large_system(): void
    {
        $project = new Project([
            'system_capacity' => 10.0, 
            'start_sunshine_hours' => 6,
            'end_sunshine_hours' => 18, 
        ]);

        $result = $this->calculator->calculate($project);

        $this->assertInstanceOf(SolarPanelCalculationDTO::class, $result);
        $this->assertGreaterThan(0, count($result->solarPanels));

        foreach ($result->solarPanels as $panelItem) {
            $this->assertInstanceOf(SolarPanelItemDTO::class, $panelItem);
            $this->assertGreaterThan(0, $panelItem->numberOfPanels);
        }
    }

    public function test_calculate_uses_highest_capacity_panels_first(): void
    {
        $project = new Project([
            'system_capacity' => 5.0,
            'start_sunshine_hours' => 7,
            'end_sunshine_hours' => 19,
        ]);

        $result = $this->calculator->calculate($project);

        $this->assertInstanceOf(SolarPanelCalculationDTO::class, $result);
        $this->assertGreaterThan(0, count($result->solarPanels));

        $firstPanel = $result->solarPanels[0];
        $this->assertEquals(3, $firstPanel->solarPanel->id);
    }
}
