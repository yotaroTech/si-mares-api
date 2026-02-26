<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $productIds = Wishlist::where('user_id', $request->user()->id)->pluck('product_id');

        $products = \App\Models\Product::with(['category', 'primaryImage', 'images', 'variants'])
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'items' => ProductListResource::collection($products),
            'product_ids' => $productIds,
        ]);
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $existing = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => $request->user()->id,
                'product_id' => $validated['product_id'],
            ]);
            $added = true;
        }

        $productIds = Wishlist::where('user_id', $request->user()->id)->pluck('product_id');

        return response()->json([
            'added' => $added,
            'product_ids' => $productIds,
        ]);
    }

    public function destroy(Request $request, int $productId)
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->delete();

        return response()->json(['message' => 'הוסר מהמועדפים']);
    }
}
