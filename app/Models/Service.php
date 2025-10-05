<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type_id',
        'is_daily_help',
        'tower_id',
        'floor_id',
        'apartment_id',
        'contact_person_name',
        'contact_number',
        'country_code',
        'company_name',
        'website_link',
        'description',
        'status',
        'photo'
    ];

    protected $casts = [
        'is_daily_help' => 'boolean',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

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

    public function getFullContactNumberAttribute()
    {
        return $this->country_code . ' ' . $this->contact_number;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-service.png');
    }
}