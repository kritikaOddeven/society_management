<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Apartment;
use App\Models\BillType;

class UtilityBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'bill_type',
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

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function billType()
    {
        return $this->belongsTo(BillType::class, 'bill_type');
    }
}
