<?php

namespace App\Providers;

use App\Models\Site;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class AppServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Per-locale route cache (php artisan route:trans:cache).
        RouteServiceProvider::loadCachedRoutesUsing(fn () => $this->loadCachedRoutes());

        // @perm('services_add') ... @endperm
        Blade::if('perm', fn (string $permission) => can_do($permission));

        View::composer('front.*', function ($view) {
            static $site;
            $site ??= Site::current();
            $lang = LaravelLocalization::getCurrentLocale();

            $view->with([
                'site' => $site,
                'lang' => $lang,
                'otherLang' => $lang === 'ar' ? 'en' : 'ar',
                'currency' => $site->currency ?? 'AED',
                'whatsapp' => $site->whatsapp ?? '#',
            ]);
        });
    }
}
