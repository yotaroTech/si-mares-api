<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $bikini = Category::where('slug', 'bikini')->first();
        $onePiece = Category::where('slug', 'one-piece')->first();
        $summer = Collection::where('slug', 'summer-2026')->first();
        $limited = Collection::where('slug', 'limited-edition')->first();

        $products = [
            [
                'name' => 'אמלפי',
                'slug' => 'amalfi',
                'subtitle' => 'בגד ים שלם מעצב',
                'category_id' => $onePiece->id,
                'collection_id' => $summer->id,
                'base_price' => 189,
                'is_new' => true,
                'description' => 'בהשראת הצוקים הדרמטיים של חוף אמלפי, בגד הים השלם הזה מעצב את הגוף עם מחשוף עמוק וגב פתוח אלגנטי. מיוצר מהבד האיטלקי הממוחזר שלנו לתחושת יוקרה כמו עור שני.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nהגנת UV UPF 50+\nטכנולוגיית ייבוש מהיר\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'כחול עמוק', 'hex' => '#1B3A5C'],
                    ['name' => 'לבן פנינה', 'hex' => '#F8F6F3'],
                    ['name' => 'זהב חולי', 'hex' => '#D4B896'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1654370488609-02aa42d7a639?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiaWtpbmklMjBzd2ltc3VpdCUyMHdvbWFuJTIwYmVhY2h8ZW58MXx8fHwxNzcyMTA4ODc3fDA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1593355837022-772f75ee073e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyZWQlMjBiaWtpbmklMjB3b21hbiUyMG1vZGVsfGVufDF8fHx8MTc3MjEwODg3OHww&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'קאפרי',
                'slug' => 'capri',
                'subtitle' => 'סט ביקיני קלאסי',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 165,
                'is_new' => true,
                'description' => 'ביקיני קאפרי לוכד את הזוהר הטבעי של האי האיטלקי. חלק עליון משולש מובנה עם אביזרי זהב משתלב עם תחתון בגזרה בינונית למראה נצחי.',
                'material' => "78% פוליאמיד ממוחזר, 22% אלסטן\nעמיד בכלור\nטכנולוגיית שמירת צורה\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'אלמוג', 'hex' => '#FF7F7F'],
                    ['name' => 'כחול אוקיינוס', 'hex' => '#2563EB'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1554565140-58ca1adc1791?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb3JhbCUyMGJpa2luaSUyMHdvbWFufGVufDF8fHx8MTc3MjEwODg3N3ww&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1568158409437-b81a8587692a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXR0ZXJuZWQlMjBiaWtpbmklMjBmbG9yYWx8ZW58MXx8fHwxNzcyMTA4ODgzfDA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'סנטוריני',
                'slug' => 'santorini',
                'subtitle' => 'ביקיני משולש',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 145,
                'is_new' => false,
                'description' => 'על שם האי האייקוני של לבן וכחול, ביקיני סנטוריני הוא שלמות מינימליסטית. קשירות עדינות וגזרה מחמיאה הופכים אותו ליוקרה יומיומית.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nהגנת UV UPF 50+\nטכנולוגיית ייבוש מהיר\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'חצות', 'hex' => '#0A1628'],
                    ['name' => 'כחול אגאי', 'hex' => '#1B3A5C'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1758657209684-7322f626ddf6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibGFjayUyMGJpa2luaSUyMHN3aW13ZWFyfGVufDF8fHx8MTc3MjEwODg3N3ww&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1691315782627-4d296d27e82f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwaW5rJTIwYmlraW5pJTIwZmFzaGlvbnxlbnwxfHx8fDE3NzIxMDg4Nzl8MA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'מיקונוס',
                'slug' => 'mykonos',
                'subtitle' => 'סט ביקיני בנדו',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 155,
                'is_new' => false,
                'description' => 'תעלו את אנרגיית המסיבה-שיק של מיקונוס עם סט הבנדו הזה. רצועות נשלפות וסילואט מעוצב מציעים גמישות מהחוף ועד הבר.',
                'material' => "78% פוליאמיד ממוחזר, 22% אלסטן\nריפוד נשלף\nרצועות נתיקות כלולות\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'לבן טהור', 'hex' => '#FFFFFF'],
                    ['name' => 'חול', 'hex' => '#D4B896'],
                    ['name' => 'נייבי', 'hex' => '#0A1628'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1770657249870-626b05295f9c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3aGl0ZSUyMGJpa2luaSUyMGJlYWNoJTIwZmFzaGlvbnxlbnwxfHx8fDE3NzIxMDg4Nzh8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1588713511404-a980e39e1329?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzdHJpcGVkJTIwYmlraW5pJTIwYmVhY2h3ZWFyfGVufDF8fHx8MTc3MjEwODg4NHww&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'ריביירה',
                'slug' => 'riviera',
                'subtitle' => 'ביקיני גזרה גבוהה',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 175,
                'is_new' => true,
                'description' => 'ביקיני ריביירה בגזרה גבוהה הוא מחווה לתור הזהב של החוף הצרפתי. תחתון גבוה מחמיא וחלק עליון תומך יוצרים סילואט של שעון חול.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nתמיכת חזיית פנים\nעיצוב גזרה גבוהה\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'תכלת', 'hex' => '#2563EB'],
                    ['name' => 'כחול עמוק', 'hex' => '#1B3A5C'],
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1760473200349-4c25a37d2a47?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibHVlJTIwYmlraW5pJTIwc3dpbXN1aXR8ZW58MXx8fHwxNzcyMTA4ODc4fDA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1654370488609-02aa42d7a639?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiaWtpbmklMjBzd2ltc3VpdCUyMHdvbWFuJTIwYmVhY2h8ZW58MXx8fHwxNzcyMTA4ODc3fDA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'פורטופינו',
                'slug' => 'portofino',
                'subtitle' => 'ביקיני חוטיני',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 135,
                'is_new' => false,
                'description' => 'כמו עיירת הנמל הקסומה עצמה, פורטופינו הוא יוקרה שקטה. קשירות חוטיני עדינות עם מתכווננים בגוון זהב מאפשרות התאמה מושלמת.',
                'material' => "78% פוליאמיד ממוחזר, 22% אלסטן\nקשירות מתכווננות\nאביזרי זהב\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'אמרלד', 'hex' => '#2E8B57'],
                    ['name' => 'פנינה', 'hex' => '#F8F6F3'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1763641007365-10f3bce27602?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncmVlbiUyMGJpa2luaSUyMHN1bW1lcnxlbnwxfHx8fDE3NzIxMDg4Nzh8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1760473200349-4c25a37d2a47?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibHVlJTIwYmlraW5pJTIwc3dpbXN1aXR8ZW58MXx8fHwxNzcyMTA4ODc4fDA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => "קוט ד'אזור",
                'slug' => 'cote-dazur',
                'subtitle' => 'בגד ים שלם יוקרתי',
                'category_id' => $onePiece->id,
                'collection_id' => $limited->id,
                'base_price' => 210,
                'is_new' => false,
                'description' => 'פסגת הקולקציה שלנו. בגד הים קוט ד\'אזור מציג חיתוכים אמנותיים, גב עמוק, ואת תערובת הבד האיטלקי היוקרתי ביותר שלנו. למי שדורשת רק את המיוחד.',
                'material' => "72% ניילון ממוחזר, 28% אלסטן\nבד איטלקי פרימיום\nדחיסה מעצבת\nבטנה מלאה עם פרט רשת\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'שחור', 'hex' => '#0A1628'],
                    ['name' => 'שמפניה', 'hex' => '#D4B896'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1691315782627-4d296d27e82f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwaW5rJTIwYmlraW5pJTIwZmFzaGlvbnxlbnwxfHx8fDE3NzIxMDg4Nzl8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1758657209684-7322f626ddf6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibGFjayUyMGJpa2luaSUyMHN3aW13ZWFyfGVufDF8fHx8MTc3MjEwODg3N3ww&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'סרדיניה',
                'slug' => 'sardinia',
                'subtitle' => 'סט ביקיני הולטר',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 158,
                'is_new' => false,
                'description' => 'הולטר סרדיניה יוצר צורה מורמת יפהפייה עם קו צוואר ארכיטקטוני. רצועות רחבות מציעות נוחות וסטייל, בעוד פרטי קיפולים מחמיאים לכל מבנה גוף.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nרצועות הולטר רחבות\nפרט קיפולים קדמי\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'ורוד שקיעה', 'hex' => '#FF69B4'],
                    ['name' => 'חול חם', 'hex' => '#E8D5B7'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1593355837022-772f75ee073e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyZWQlMjBiaWtpbmklMjB3b21hbiUyMG1vZGVsfGVufDF8fHx8MTc3MjEwODg3OHww&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1554565140-58ca1adc1791?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb3JhbCUyMGJpa2luaSUyMHdvbWFufGVufDF8fHx8MTc3MjEwODg3N3ww&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'איביזה',
                'slug' => 'ibiza',
                'subtitle' => 'בגד ים שלם עם חיתוכים',
                'category_id' => $onePiece->id,
                'collection_id' => $limited->id,
                'base_price' => 195,
                'is_new' => true,
                'description' => 'נועז וחופשי כמו האי עצמו. איביזה מציג חיתוכי צד נועזים עם אביזרי טבעת, מושך מבטים ממועדון החוף ועד למסיבת השקיעה.',
                'material' => "78% פוליאמיד ממוחזר, 22% אלסטן\nאביזרי טבעת בגוון זהב\nפרט חיתוכי צד\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'כתום שקיעה', 'hex' => '#FF8C00'],
                    ['name' => 'קרם', 'hex' => '#F8F6F3'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1756223934811-0e7cf10a56b2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvcmFuZ2UlMjBiaWtpbmklMjBzdW5zaGluZXxlbnwxfHx8fDE3NzIxMDg4ODN8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1770657249870-626b05295f9c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3aGl0ZSUyMGJpa2luaSUyMGJlYWNoJTIwZmFzaGlvbnxlbnwxfHx8fDE3NzIxMDg4Nzh8MA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'קורסיקה',
                'slug' => 'corsica',
                'subtitle' => 'סט ביקיני מעטפת',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 148,
                'sale_price' => 148,
                'original_price' => 185,
                'is_new' => false,
                'description' => 'חלק עליון מעטפת קורסיקה מחמיא בלי סוף עם ההתאמה המתכווננת שלו. פרט צלב קדמי וסגירת קשירה בגב יוצרים סילואט יפהפה ומותאם אישית.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nעיצוב מעטפת\nכיסוי מתכוונן\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'הדפס פרחוני', 'hex' => '#FFB6C1'],
                    ['name' => 'כחול ים תיכוני', 'hex' => '#4169E1'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1568158409437-b81a8587692a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxwYXR0ZXJuZWQlMjBiaWtpbmklMjBmbG9yYWx8ZW58MXx8fHwxNzcyMTA4ODgzfDA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1763641007365-10f3bce27602?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncmVlbiUyMGJpa2luaSUyMHN1bW1lcnxlbnwxfHx8fDE3NzIxMDg4Nzh8MA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'מלטה',
                'slug' => 'malta',
                'subtitle' => 'בגד ים שלם עם קיפולים',
                'category_id' => $onePiece->id,
                'collection_id' => $summer->id,
                'base_price' => 178,
                'is_new' => false,
                'description' => 'קיפולים מתוחכמים יוצרים אפקט מחמיא במיוחד על בגד הים השלם הנצחי הזה. מלטה משלבת פסים ימיים קלאסיים עם טכנולוגיית עיצוב מודרנית.',
                'material' => "78% פוליאמיד ממוחזר, 22% אלסטן\nקיפולי עיצוב בטן\nרצועות מתכווננות\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'פסי נייבי', 'hex' => '#000080'],
                    ['name' => 'שנהב', 'hex' => '#FFFFF0'],
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1588713511404-a980e39e1329?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzdHJpcGVkJTIwYmlraW5pJTIwYmVhY2h3ZWFyfGVufDF8fHx8MTc3MjEwODg4NHww&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1593355837022-772f75ee073e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyZWQlMjBiaWtpbmklMjB3b21hbiUyMG1vZGVsfGVufDF8fHx8MTc3MjEwODg3OHww&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
            [
                'name' => 'פוזיטנו',
                'slug' => 'positano',
                'subtitle' => 'סט ביקיני מחשוף עמוק',
                'category_id' => $bikini->id,
                'collection_id' => $summer->id,
                'base_price' => 162,
                'sale_price' => 162,
                'original_price' => 198,
                'is_new' => false,
                'description' => 'לכדו את הקסם הזהוב של שקיעות פוזיטנו מעל הצוקים. ביקיני עם מחשוף עמוק בצורת V עם פרט קשירה ותחתון בגזרה ברזילאית.',
                'material' => "80% ניילון ממוחזר, 20% אלסטן\nפרט קשר קדמי\nתחתון גזרה ברזילאית\nבטנה מלאה\nיוצר באיטליה",
                'shipping_info' => "משלוח חינם בהזמנות מעל ₪499.\nמשלוח רגיל: 3-5 ימי עסקים.\nמשלוח מהיר: 1-2 ימי עסקים.\nהחזרות חינם עד 30 יום.",
                'colors' => [
                    ['name' => 'שעת הזהב', 'hex' => '#FFD700'],
                    ['name' => 'טרקוטה', 'hex' => '#CC7744'],
                ],
                'sizes' => ['XS', 'S', 'M', 'L'],
                'images' => [
                    'https://images.unsplash.com/photo-1654370488609-02aa42d7a639?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiaWtpbmklMjBzd2ltc3VpdCUyMHdvbWFuJTIwYmVhY2h8ZW58MXx8fHwxNzcyMTA4ODc3fDA&ixlib=rb-4.1.0&q=80&w=1080',
                    'https://images.unsplash.com/photo-1756223934811-0e7cf10a56b2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvcmFuZ2UlMjBiaWtpbmklMjBzdW5zaGluZXxlbnwxfHx8fDE3NzIxMDg4ODN8MA&ixlib=rb-4.1.0&q=80&w=1080',
                ],
            ],
        ];

        foreach ($products as $index => $data) {
            $colors = $data['colors'];
            $sizes = $data['sizes'];
            $images = $data['images'];
            unset($data['colors'], $data['sizes'], $data['images']);

            // Handle sale products
            $salePrice = null;
            if (isset($data['original_price'])) {
                $data['base_price'] = $data['original_price'];
                $salePrice = $data['sale_price'];
                unset($data['original_price']);
            } else {
                unset($data['sale_price']);
            }

            $slug = $data['slug'];
            $product = Product::create(array_merge($data, [
                'sale_price' => $salePrice,
                'sort_order' => $index + 1,
            ]));

            // Create variants for each color+size combination
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => 'SM-' . strtoupper($slug) . '-' . strtoupper(substr(str_replace('#', '', $color['hex']), 0, 4)) . '-' . $size,
                        'color_name' => $color['name'],
                        'color_hex' => $color['hex'],
                        'size' => $size,
                        'stock' => 10,
                    ]);
                }
            }

            // Create images
            foreach ($images as $imgIndex => $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'alt_text' => $product->name,
                    'sort_order' => $imgIndex,
                    'is_primary' => $imgIndex === 0,
                ]);
            }
        }
    }
}
