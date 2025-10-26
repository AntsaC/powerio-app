<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Option;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationLine;
use App\Models\SolarPanel;
use App\Models\User;
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
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@powerio.com',
        ]);

        // Create solar panels
        SolarPanel::factory(5)->create();

        // Create options (10 predefined options)
        Option::factory(10)->create();

        // Create customers (some will have multiple projects)
        $customers = Customer::factory(15)->create();

        // Create projects - some customers will have multiple projects
        $projects = collect();

        // Give some customers multiple projects
        $customers->each(function ($customer) use (&$projects) {
            $projectCount = fake()->numberBetween(1, 3); // Each customer gets 1-3 projects
            $customerProjects = Project::factory($projectCount)->create([
                'customer_id' => $customer->id,
            ]);
            $projects = $projects->merge($customerProjects);
        });

        // Create quotations for some projects
        $projects->random(min(10, $projects->count()))->each(function ($project) {
            Quotation::factory(rand(1, 2))->create([
                'project_id' => $project->id,
            ]);
        });

        // Create quotation lines
        Quotation::all()->each(function ($quotation) {
            QuotationLine::factory(rand(3, 8))->create([
                'quotation_id' => $quotation->id,
            ]);
        });
    }
}
