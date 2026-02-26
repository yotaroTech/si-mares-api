<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingZone;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createFromCart(
        int $userId,
        array $shippingAddress,
        int $shippingZoneId,
        ?string $couponCode = null,
        ?string $notes = null
    ): Order {
        return DB::transaction(function () use ($userId, $shippingAddress, $shippingZoneId, $couponCode, $notes) {
            $cartItems = CartItem::with('variant.product')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('העגלה ריקה');
            }

            // Verify stock
            foreach ($cartItems as $item) {
                if ($item->variant->stock < $item->quantity) {
                    throw new \Exception("אין מספיק מלאי עבור {$item->variant->product->name} ({$item->variant->size})");
                }
            }

            $subtotal = $cartItems->sum(fn($item) => $item->variant->price * $item->quantity);

            // Shipping
            $shippingZone = ShippingZone::findOrFail($shippingZoneId);
            $shippingCost = $shippingZone->cost;
            if ($shippingZone->min_order_free && $subtotal >= $shippingZone->min_order_free) {
                $shippingCost = 0;
            }

            // Coupon
            $discount = 0;
            $coupon = null;
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon && $coupon->isValid($subtotal)) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    if ($coupon->type->value === 'free_shipping') {
                        $shippingCost = 0;
                    }
                }
            }

            $total = $subtotal - $discount + $shippingCost;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $userId,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => max(0, $total),
                'shipping_address' => $shippingAddress,
                'payment_status' => 'pending',
                'coupon_id' => $coupon?->id,
                'notes' => $notes,
            ]);

            // Create order items and reduce stock
            foreach ($cartItems as $item) {
                $variant = $item->variant;
                $product = $variant->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $product->name,
                    'variant_info' => "{$variant->color_name} / {$variant->size}",
                    'sku' => $variant->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $variant->price,
                    'total_price' => $variant->price * $item->quantity,
                ]);

                $variant->decrement('stock', $item->quantity);
            }

            // Increment coupon usage
            if ($coupon) {
                $coupon->increment('uses_count');
            }

            // Clear cart
            CartItem::where('user_id', $userId)->delete();

            return $order->load('items');
        });
    }
}
