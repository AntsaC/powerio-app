<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Option;
use App\Models\Project;
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

        SolarPanel::factory(5)->create();

        Option::factory(10)->create();

        $customers = Customer::factory(15)->create();

        $projects = collect();

        $customers->each(function ($customer) use (&$projects) {
            $projectCount = fake()->numberBetween(1, 3); // Each customer gets 1-3 projects
            $customerProjects = Project::factory($projectCount)->create([
                'customer_id' => $customer->id,
            ]);
            $projects = $projects->merge($customerProjects);
        });
    }
}
