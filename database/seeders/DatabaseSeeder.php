<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationLine;
use App\Models\SolarPanel;
use App\Models\User;
use Database\Factories\QuotationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SolarPanel::factory(5)->create();

        Project::factory(5)->create();

        Quotation::factory(5)->create();

        QuotationLine::factory(10)->create();
    }
}
