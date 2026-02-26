<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validate(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $validated['code'])->first();

        if (!$coupon || !$coupon->isValid($validated['subtotal'])) {
            return response()->json([
                'valid' => false,
                'message' => 'קוד קופון לא תקף',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($validated['subtotal']);

        return response()->json([
            'valid' => true,
            'code' => $coupon->code,
            'type' => $coupon->type->value,
            'discount_amount' => $discount,
            'free_shipping' => $coupon->type->value === 'free_shipping',
        ]);
    }
}
