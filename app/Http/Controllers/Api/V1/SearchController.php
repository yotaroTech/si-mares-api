<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $query = $request->input('q');

        $products = Product::with(['category', 'primaryImage', 'images', 'variants'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'ilike', "%{$query}%")
                  ->orWhere('subtitle', 'ilike', "%{$query}%")
                  ->orWhere('description', 'ilike', "%{$query}%")
                  ->orWhereHas('category', fn($cat) => $cat->where('name', 'ilike', "%{$query}%"));
            })
            ->limit(20)
            ->get();

        return response()->json([
            'results' => ProductListResource::collection($products),
            'count' => $products->count(),
        ]);
    }
}
