<?php

namespace App\Repositories;

use App\Models\SolarPanel;
use Illuminate\Database\Eloquent\Collection;

class SolarPanelRepository
{
    public function getAllOrderedByNominalPower(): Collection
    {
        return SolarPanel::orderBy('nominal_power', 'desc')->get();
    }
}
