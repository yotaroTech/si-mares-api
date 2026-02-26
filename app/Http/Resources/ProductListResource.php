<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'subtitle' => $this->subtitle,
            'category' => $this->category->name_en,
            'category_name' => $this->category->name,
            'collection' => $this->whenLoaded('collection', fn() => $this->collection?->name),
            'base_price' => (float) $this->base_price,
            'sale_price' => $this->sale_price ? (float) $this->sale_price : null,
            'current_price' => $this->current_price,
            'is_on_sale' => $this->isOnSale(),
            'is_new' => $this->is_new,
            'primary_image' => $this->whenLoaded('primaryImage', fn() => $this->primaryImage?->image_path),
            'images' => $this->whenLoaded('images', fn() => $this->images->pluck('image_path')),
            'colors' => $this->whenLoaded('variants', function () {
                return $this->variants
                    ->unique('color_name')
                    ->map(fn($v) => ['name' => $v->color_name, 'hex' => $v->color_hex])
                    ->values();
            }),
            'sizes' => $this->whenLoaded('variants', function () {
                return $this->variants->pluck('size')->unique()->values();
            }),
        ];
    }
}
