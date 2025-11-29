<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerFamily extends Model
{
        protected $fillable = [
        'owner_id',
        'name',
        'relation',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}