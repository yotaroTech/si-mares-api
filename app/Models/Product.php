<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'description',
        'category_id',
        'collection_id',
        'base_price',
        'sale_price',
        'sale_start',
        'sale_end',
        'material',
        'shipping_info',
        'is_new',
        'is_active',
        'seo_title',
        'seo_description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'sale_start' => 'datetime',
            'sale_end' => 'datetime',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->sale_price && $this->isOnSale()) {
            return (float) $this->sale_price;
        }
        return (float) $this->base_price;
    }

    public function isOnSale(): bool
    {
        if (!$this->sale_price) {
            return false;
        }
        $now = now();
        if ($this->sale_start && $now->lt($this->sale_start)) {
            return false;
        }
        if ($this->sale_end && $now->gt($this->sale_end)) {
            return false;
        }
        return true;
    }

    public function getTotalStockAttribute(): int
    {
        return $this->variants()->where('is_active', true)->sum('stock');
    }
}
