<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'name_en' => $this->category->name_en,
                'slug' => $this->category->slug,
            ],
            'collection' => $this->whenLoaded('collection', fn() => $this->collection ? [
                'id' => $this->collection->id,
                'name' => $this->collection->name,
                'slug' => $this->collection->slug,
            ] : null),
            'base_price' => (float) $this->base_price,
            'sale_price' => $this->sale_price ? (float) $this->sale_price : null,
            'current_price' => $this->current_price,
            'is_on_sale' => $this->isOnSale(),
            'is_new' => $this->is_new,
            'material' => $this->material,
            'shipping_info' => $this->shipping_info,
            'images' => $this->images->map(fn($img) => [
                'id' => $img->id,
                'url' => $img->image_path,
                'alt' => $img->alt_text,
                'is_primary' => $img->is_primary,
            ]),
            'colors' => $this->variants
                ->unique('color_name')
                ->map(fn($v) => ['name' => $v->color_name, 'hex' => $v->color_hex])
                ->values(),
            'sizes' => $this->variants->pluck('size')->unique()->values(),
            'variants' => $this->variants->map(fn($v) => [
                'id' => $v->id,
                'sku' => $v->sku,
                'color_name' => $v->color_name,
                'color_hex' => $v->color_hex,
                'size' => $v->size,
                'price' => $v->price,
                'stock' => $v->stock,
                'is_active' => $v->is_active,
            ]),
        ];
    }
}
