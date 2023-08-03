<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class Localization
{
    private Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale');

        if (!in_array($locale, config("translatable.locales")) && !is_null($locale)) {
            abort(400);
        }

        if (is_null($locale)) {
            $locale = config('app.locale');
            session(["locale" => $locale]);
        }

        $this->application->setLocale($locale);
        return $next($request);
    }
}
