<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'SI MARES',
                'subtitle' => 'בגדי ים יוקרתיים מהים התיכון',
                'image_path' => 'https://images.unsplash.com/photo-1639222188528-3498adec4f40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWFjaCUyMHN1bW1lciUyMHZhY2F0aW9uJTIwdHJvcGljYWx8ZW58MXx8fHwxNzcyMTI1NjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
                'link_url' => '/catalog',
                'link_text' => 'לקולקציה',
                'sort_order' => 1,
            ],
            [
                'title' => 'קולקציית קיץ 2026',
                'subtitle' => 'פריטי חובה שטופי שמש',
                'image_path' => 'https://images.unsplash.com/photo-1728051104013-d8c6f056f6da?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzd2ltbWluZyUyMHBvb2wlMjBiaWtpbmklMjByZXNvcnR8ZW58MXx8fHwxNzcyMTI1NjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
                'link_url' => '/catalog',
                'link_text' => 'גלי עכשיו',
                'sort_order' => 2,
            ],
            [
                'title' => 'מהדורה מוגבלת',
                'subtitle' => 'פריטים בלעדיים שלא תמצאי בשום מקום אחר',
                'image_path' => 'https://images.unsplash.com/photo-1727640297123-985cd2f7d9f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvY2VhbiUyMHdhdmVzJTIwYmVhY2glMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzIxMjU2MzV8MA&ixlib=rb-4.1.0&q=80&w=1080',
                'link_url' => '/catalog',
                'link_text' => 'לקולקציה',
                'sort_order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}
