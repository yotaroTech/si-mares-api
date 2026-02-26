<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            CollectionSeeder::class,
            ProductSeeder::class,
            HeroSlideSeeder::class,
            SiteSettingSeeder::class,
            ShippingZoneSeeder::class,
        ]);
    }
}
