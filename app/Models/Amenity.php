<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
  protected $fillable = ['tower_id', 'amenity_name','open_time', 'close_time', 'status'];
    
    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }
}