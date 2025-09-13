<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'tower_id',
        'floor_id',
        'apartment_id',
        'tenant_id',
        'tenant_name',
        'rent_year',
        'rent_month',
        'rent_amount',
        'status',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'rent_amount' => 'decimal:2',
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Get all months as array
    public static function getMonths()
    {
        return [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    }

    // Get years for dropdown (current year and 5 years back/forward)
    public static function getYears()
    {
        $currentYear = date('Y');
        $years = [];
        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++) {
            $years[] = $i;
        }
        return $years;
    }

    // Check if rent exists for a specific period
    public static function rentExists($apartmentId, $tenantId, $year, $month)
    {
        return self::where('apartment_id', $apartmentId)
            ->where('tenant_id', $tenantId)
            ->where('rent_year', $year)
            ->where('rent_month', $month)
            ->exists();
    }
}