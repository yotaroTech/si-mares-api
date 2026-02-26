<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
        ]);
    }
}
