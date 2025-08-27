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
        'parking_id',
        'owner_id',
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

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

}
