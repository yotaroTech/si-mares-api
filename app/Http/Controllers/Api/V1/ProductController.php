<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'collection', 'primaryImage', 'images', 'variants'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('collection')) {
            $query->whereHas('collection', fn($q) => $q->where('slug', $request->collection));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants', fn($q) => $q->where('size', $request->size)->where('stock', '>', 0));
        }

        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        if ($request->filled('new')) {
            $query->where('is_new', true);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('subtitle', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'recommended');
        match ($sort) {
            'price_asc' => $query->orderBy('base_price', 'asc'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('sort_order', 'asc'),
        };

        $perPage = $request->input('per_page', 24);
        $products = $query->paginate($perPage);

        return ProductListResource::collection($products);
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'collection', 'images', 'variants' => fn($q) => $q->where('is_active', true)])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::with(['category', 'primaryImage', 'images', 'variants'])
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->limit(4)
            ->get();

        if ($related->count() < 4) {
            $moreIds = $related->pluck('id')->push($product->id);
            $more = Product::with(['category', 'primaryImage', 'images', 'variants'])
                ->where('is_active', true)
                ->whereNotIn('id', $moreIds)
                ->limit(4 - $related->count())
                ->get();
            $related = $related->merge($more);
        }

        return response()->json([
            'product' => new ProductResource($product),
            'related' => ProductListResource::collection($related),
        ]);
    }
}
