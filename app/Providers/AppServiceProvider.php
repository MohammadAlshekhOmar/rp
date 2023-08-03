<?php

namespace App\Providers;

use App\Enums\SettingEnum;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            Blade::directive('price', function ($price) {
                return "<?php echo number_format($price); ?>";
            });

            $brand = Setting::where('type', SettingEnum::Brand->value)->first()?->value;
            $view->with('brand', $brand);

            $loggin = false;
            if (auth()->guard('admin')->check()) {
                $user = Admin::find(auth()->guard('admin')->user()->id);
                $loggin = true;
            } else if (auth()->guard('web')->check()) {
                $user = User::find(auth()->guard('web')->user()->id);
                $loggin = true;
            }

            if ($loggin) {
                $number_notifications = $user->notifications()->where('is_read', 0)->count();
                $notis = $user->notifications()->latest()->get();

                $view->with('number_notifications', $number_notifications);
                $view->with('notis', $notis);
            }
        });
    }
}
