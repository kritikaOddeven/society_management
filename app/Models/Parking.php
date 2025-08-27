<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
     protected $fillable = [
        'apartment_id',
        'parking_code',
        'floor_id',
        'status',
    ];

    // Relations
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

  

}
