<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manufacturer',
        'model',
        'nominal_power',
        'efficiency',
        'price',
        'description',
    ];

    protected $casts = [
        'nominal_power' => 'decimal:2',
        'efficiency' => 'decimal:2',
        'price' => 'decimal:2',
    ];
}
