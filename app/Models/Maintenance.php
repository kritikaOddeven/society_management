<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'maintenance_type',
        'apartment_type',
        'annual_value',
        'half_yearly_value',
        'quarterly_value',
        'monthly_value',
        'unit_name',
        'unit_value',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'annual_value' => 'decimal:2',
        'half_yearly_value' => 'decimal:2',
        'quarterly_value' => 'decimal:2',
        'monthly_value' => 'decimal:2',
        'unit_value' => 'decimal:2',
    ];
}
