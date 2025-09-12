<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
     protected $fillable = [
        'name',
        'email',
        'phone_number',
        'country_code',
        'profile_image',
        'apartment_id',
        'bill_cycle',
        'rent_amount',
        'contract_start_date',
        'contract_end_date',
    ];

     public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}