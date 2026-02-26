<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\ProductListResource;
use App\Models\Collection;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\SiteSetting;

class StorefrontController extends Controller
{
    public function home()
    {
        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'image' => $s->image_path,
                'link_url' => $s->link_url,
                'link_text' => $s->link_text,
            ]);

        $collections = Collection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $newArrivals = Product::with(['category', 'primaryImage', 'images', 'variants'])
            ->where('is_active', true)
            ->where('is_new', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $brandStory = [
            'title' => SiteSetting::get('brand_story_title'),
            'subtitle' => SiteSetting::get('brand_story_subtitle'),
            'text_1' => SiteSetting::get('brand_story_text_1'),
            'text_2' => SiteSetting::get('brand_story_text_2'),
            'image' => SiteSetting::get('brand_story_image'),
        ];

        $instagramImages = json_decode(SiteSetting::get('instagram_images', '[]'), true);

        return response()->json([
            'hero_slides' => $heroSlides,
            'collections' => CollectionResource::collection($collections),
            'new_arrivals' => ProductListResource::collection($newArrivals),
            'brand_story' => $brandStory,
            'instagram_images' => $instagramImages,
            'instagram_url' => SiteSetting::get('instagram_url'),
        ]);
    }

    public function settings()
    {
        return response()->json([
            'site_name' => SiteSetting::get('site_name'),
            'site_tagline' => SiteSetting::get('site_tagline'),
            'currency' => SiteSetting::get('currency'),
            'currency_symbol' => SiteSetting::get('currency_symbol'),
            'free_shipping_threshold' => (float) SiteSetting::get('free_shipping_threshold', '0'),
            'newsletter_title' => SiteSetting::get('newsletter_title'),
            'newsletter_description' => SiteSetting::get('newsletter_description'),
        ]);
    }
}
