<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerDocument extends Model
{
    protected $fillable = ['owner_id', 'doc_name', 'doc_file'];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}