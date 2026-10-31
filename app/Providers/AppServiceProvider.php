<?php

namespace App\Providers;

use App\Models\Site;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // @perm('services_add') ... @endperm
        Blade::if('perm', fn (string $permission) => can_do($permission));

        View::composer('front.*', function ($view) {
            static $site;
            $site ??= Site::query()->first();
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
