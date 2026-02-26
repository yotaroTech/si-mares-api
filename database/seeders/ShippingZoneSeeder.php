<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        ShippingZone::create([
            'name' => 'משלוח רגיל',
            'zone_type' => 'domestic',
            'cost' => 29,
            'min_order_free' => 499,
            'estimated_days_min' => 3,
            'estimated_days_max' => 5,
        ]);

        ShippingZone::create([
            'name' => 'משלוח מהיר',
            'zone_type' => 'express',
            'cost' => 49,
            'min_order_free' => null,
            'estimated_days_min' => 1,
            'estimated_days_max' => 2,
        ]);
    }
}
