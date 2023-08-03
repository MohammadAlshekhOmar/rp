<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/adminMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        view()->share('menuData', [$verticalMenuData]);
    }
}
