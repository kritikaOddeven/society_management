<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'country_code',
        'profile_image',
        'tower_id',
        'floor_id',
        'apartment_id',
        'status',
    ];

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'owner_id');
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
}
