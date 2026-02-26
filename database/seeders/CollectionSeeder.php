<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        Collection::create([
            'name' => 'קיץ 2026',
            'slug' => 'summer-2026',
            'description' => 'פריטי חובה שטופי שמש לעונת הים התיכון',
            'image_path' => 'https://images.unsplash.com/photo-1639222188528-3498adec4f40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWFjaCUyMHN1bW1lciUyMHZhY2F0aW9uJTIwdHJvcGljYWx8ZW58MXx8fHwxNzcyMTI1NjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'sort_order' => 1,
        ]);

        Collection::create([
            'name' => 'מהדורה מוגבלת',
            'slug' => 'limited-edition',
            'description' => 'פריטים בלעדיים, מעוצבים ליוצא מן הכלל',
            'image_path' => 'https://images.unsplash.com/photo-1728051104013-d8c6f056f6da?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzd2ltbWluZyUyMHBvb2wlMjBiaWtpbmklMjByZXNvcnR8ZW58MXx8fHwxNzcyMTI1NjM1fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'sort_order' => 2,
        ]);
    }
}
