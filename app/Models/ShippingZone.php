<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'zone_type',
        'regions',
        'cost',
        'min_order_free',
        'estimated_days_min',
        'estimated_days_max',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'regions' => 'array',
            'cost' => 'decimal:2',
            'min_order_free' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
