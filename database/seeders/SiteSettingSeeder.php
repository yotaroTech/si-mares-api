<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'SI MARES', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'בגדי ים יוקרתיים מהים התיכון', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'ILS', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => '₪', 'group' => 'general'],

            // Brand Story
            ['key' => 'brand_story_title', 'value' => 'נולד מהים', 'group' => 'brand'],
            ['key' => 'brand_story_subtitle', 'value' => 'הסיפור שלנו', 'group' => 'brand'],
            ['key' => 'brand_story_text_1', 'value' => 'SI MARES נולד על חופי הים התיכון שטופי השמש, שם הים התכול פוגש אבן עתיקה ואור זהוב. כל פריט בקולקציה שלנו הוא מחווה ליופי הנצחי הזה.', 'group' => 'brand'],
            ['key' => 'brand_story_text_2', 'value' => 'מיוצר באיטליה מבדים בני קיימא, בגדי הים שלנו מעוצבים לאישה שמחפשת אלגנטיות בכל רגע — מהשחייה הראשונה בבוקר ועד הקוקטייל האחרון בשקיעה.', 'group' => 'brand'],
            ['key' => 'brand_story_image', 'value' => 'https://images.unsplash.com/photo-1727640297123-985cd2f7d9f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvY2VhbiUyMHdhdmVzJTIwYmVhY2glMjBwYXJhZGlzZXxlbnwxfHx8fDE3NzIxMjU2MzV8MA&ixlib=rb-4.1.0&q=80&w=1080', 'group' => 'brand'],

            // Instagram
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/simares', 'group' => 'social'],
            ['key' => 'instagram_images', 'value' => json_encode([
                'https://images.unsplash.com/photo-1654370488609-02aa42d7a639?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
                'https://images.unsplash.com/photo-1639222188528-3498adec4f40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
                'https://images.unsplash.com/photo-1554565140-58ca1adc1791?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
                'https://images.unsplash.com/photo-1728051104013-d8c6f056f6da?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
                'https://images.unsplash.com/photo-1593355837022-772f75ee073e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
                'https://images.unsplash.com/photo-1727640297123-985cd2f7d9f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400',
            ]), 'group' => 'social'],

            // Shipping
            ['key' => 'free_shipping_threshold', 'value' => '499', 'group' => 'shipping'],

            // Newsletter
            ['key' => 'newsletter_title', 'value' => 'הצטרפו לעולם SI MARES', 'group' => 'newsletter'],
            ['key' => 'newsletter_description', 'value' => 'קבלו גישה מוקדמת לקולקציות חדשות, הצעות בלעדיות והשראה ים תיכונית ישירות לתיבת המייל.', 'group' => 'newsletter'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
