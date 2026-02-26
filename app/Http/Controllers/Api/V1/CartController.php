<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->getCartQuery($request)
            ->with(['variant.product.primaryImage', 'variant.product.category'])
            ->get();

        $cartItems = $items->map(fn($item) => $this->formatCartItem($item));
        $subtotal = $items->sum(fn($item) => $item->variant->price * $item->quantity);

        return response()->json([
            'items' => $cartItems,
            'subtotal' => round($subtotal, 2),
            'item_count' => $items->sum('quantity'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        $variant = ProductVariant::findOrFail($validated['product_variant_id']);

        if ($variant->stock < ($validated['quantity'] ?? 1)) {
            return response()->json(['message' => 'אין מספיק מלאי'], 422);
        }

        $existing = $this->getCartQuery($request)
            ->where('product_variant_id', $validated['product_variant_id'])
            ->first();

        if ($existing) {
            $existing->update(['quantity' => $existing->quantity + ($validated['quantity'] ?? 1)]);
        } else {
            CartItem::create([
                'user_id' => $request->user()?->id,
                'session_id' => $request->user() ? null : $request->session()->getId(),
                'product_variant_id' => $validated['product_variant_id'],
                'quantity' => $validated['quantity'] ?? 1,
            ]);
        }

        return $this->index($request);
    }

    public function update(Request $request, CartItem $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart->update($validated);

        return $this->index($request);
    }

    public function destroy(Request $request, CartItem $cart)
    {
        $cart->delete();
        return $this->index($request);
    }

    public function clear(Request $request)
    {
        $this->getCartQuery($request)->delete();

        return response()->json([
            'items' => [],
            'subtotal' => 0,
            'item_count' => 0,
        ]);
    }

    public function merge(Request $request)
    {
        $sessionId = $request->session()->getId();
        $userId = $request->user()->id;

        $guestItems = CartItem::where('session_id', $sessionId)->get();

        foreach ($guestItems as $guestItem) {
            $existing = CartItem::where('user_id', $userId)
                ->where('product_variant_id', $guestItem->product_variant_id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $guestItem->quantity]);
                $guestItem->delete();
            } else {
                $guestItem->update(['user_id' => $userId, 'session_id' => null]);
            }
        }

        return $this->index($request);
    }

    private function getCartQuery(Request $request)
    {
        if ($request->user()) {
            return CartItem::where('user_id', $request->user()->id);
        }
        return CartItem::where('session_id', $request->session()->getId());
    }

    private function formatCartItem(CartItem $item): array
    {
        $variant = $item->variant;
        $product = $variant->product;

        return [
            'id' => $item->id,
            'quantity' => $item->quantity,
            'variant_id' => $variant->id,
            'sku' => $variant->sku,
            'color_name' => $variant->color_name,
            'color_hex' => $variant->color_hex,
            'size' => $variant->size,
            'price' => $variant->price,
            'stock' => $variant->stock,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->primaryImage?->image_path,
                'category' => $product->category->name,
            ],
            'line_total' => round($variant->price * $item->quantity, 2),
        ];
    }
}
