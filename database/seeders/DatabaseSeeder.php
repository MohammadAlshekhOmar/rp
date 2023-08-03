<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            RegionSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            InfoSeeder::class,
            ProviderSeeder::class,
            AdStatusSeeder::class,
            AdSeeder::class,
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            ServiceSeeder::class,
            OrderStatusSeeder::class,
        ]);
    }
}
