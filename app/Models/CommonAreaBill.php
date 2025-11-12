<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BillType;

class CommonAreaBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_type_id',
        'bill_amount',
        'payment_mode',
        'bill_date',
        'bill_due_date',
        'bill_image',
        'status',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'bill_due_date' => 'date',
        'bill_amount' => 'decimal:2',
    ];

    public function billType()
    {
        return $this->belongsTo(BillType::class);
    }
}
