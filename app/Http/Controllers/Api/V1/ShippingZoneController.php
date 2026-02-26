<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;

class ShippingZoneController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::where('is_active', true)->get();

        return response()->json([
            'zones' => $zones->map(fn($z) => [
                'id' => $z->id,
                'name' => $z->name,
                'type' => $z->zone_type,
                'cost' => (float) $z->cost,
                'min_order_free' => $z->min_order_free ? (float) $z->min_order_free : null,
                'estimated_days' => "{$z->estimated_days_min}-{$z->estimated_days_max}",
            ]),
        ]);
    }
}
