<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentType extends Model
{
    protected $fillable = [
        'apartment_type',
        'status',
    ];
}
