<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{

    protected $fillable = ['tower_id', 'floor_name', 'status'];
    
    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }

}
