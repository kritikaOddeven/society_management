<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    protected $fillable = [
        'tower_name',
        'status',
    ];

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

}
