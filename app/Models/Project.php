<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'name',
        'description',
        'status',
        'location',
        'latitude',
        'longitude',
        'system_capacity',
        'installation_type',
        'start_sunshine_hours',
        'end_sunshine_hours',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'system_capacity' => 'decimal:2'
    ];

    /**
     * Get the customer that owns this project
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get all quotations for this project
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function convertSystemCapacityInWhat(): float {
        return $this->system_capacity * 1000;
    }

    public function getSunshineDailyHour() : int {
        return $this->end_sunshine_hours - $this->start_sunshine_hours;
    }
}
