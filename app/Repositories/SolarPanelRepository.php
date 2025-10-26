<?php

namespace App\Repositories;

use App\Models\SolarPanel;
use Illuminate\Database\Eloquent\Collection;

class SolarPanelRepository
{
    public function getAllOrderedByCapacity(): Collection
    {
        return SolarPanel::orderBy('system_capacity', 'desc')->get();
    }
}
