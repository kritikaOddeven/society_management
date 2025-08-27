<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
     protected $fillable = [
        'tower_id',
        'floor_id',
        'apartment_number',
        'apartment_area',
        'apartment_type',
        'status',
    ];

     public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function type()
    {
        return $this->belongsTo(ApartmentType::class, 'apartment_type');
    }
}
