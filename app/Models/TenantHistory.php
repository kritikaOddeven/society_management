<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TenantHistory extends Model
{
    protected $fillable = [
        'tenant_id',
        'action',
        'name',
        'email',
        'phone_number',
        'country_code',
        'profile_image',
        'apartment_id',
        'bill_cycle',
        'rent_amount',
        'contract_start_date',
        'contract_end_date',
        'status',
        'changed_fields',
        'changed_by'
    ];

    protected $casts = [
        'changed_fields' => 'array',
        'status' => 'boolean',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public static function logChange($tenant, $action, $changedFields = null, $userId = null)
    {
        return self::create([
            'tenant_id' => $tenant->id,
            'action' => $action,
            'name' => $tenant->name,
            'email' => $tenant->email,
            'phone_number' => $tenant->phone_number,
            'country_code' => $tenant->country_code,
            'profile_image' => $tenant->profile_image,
            'apartment_id' => $tenant->apartment_id,
            'bill_cycle' => $tenant->bill_cycle,
            'rent_amount' => $tenant->rent_amount,
            'contract_start_date' => $tenant->contract_start_date,
            'contract_end_date' => $tenant->contract_end_date,
            'status' => $tenant->status ?? true,
            'changed_fields' => $changedFields,
            'changed_by' => $userId ?? auth()->id()
        ]);
    }
}