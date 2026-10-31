<?php

use App\Http\Controllers\Admin\{
    PatientController,
    SiteController,
    BookingController,
    DailyController,
    OpinionController,
    VideoController,
    GroupController,
    BlogController,
    PagesController,
    DepartmentController,
    NewsletterController,
    UserController,
    AdminsController,
    SliderController,
    ContactController,
    ProjectController,
    ClientController,
    ServiceController,
    FeatureController,
    CalculatorItemController,
    CostRequestController,
    InvoiceController,
    AdminController
};
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\HomeController;

Route::get('reload-captcha', [HomeController::class, 'reloadCaptcha']);

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        ], function () {
            Auth::routes(['register' => false]);

            Route::group(array('prefix' => 'trika', 'middleware' => 'admin'), function () {
                Route::resource('patient', PatientController::class)->except('show')->middleware('role:patient');
                Route::resource('booking', BookingController::class)->only('index', 'edit', 'update', 'destroy')->middleware('role:booking');
                Route::resource('daily', DailyController::class)->except('show')->middleware('role:daily');
                Route::resource('opinions', OpinionController::class)->except('show')->middleware('role:opinion');
                Route::resource('videos', VideoController::class)->except('show')->middleware('role:video');
                Route::resource('site', SiteController::class)->only('index', 'update')->middleware('role:site');
                Route::resource('groups', GroupController::class)->except('show')->middleware('role:groups');
                Route::resource('news', BlogController::class)->except('show')->middleware('role:news');
                Route::resource('pages', PagesController::class)->except('show')->middleware('role:pages');
                Route::resource('depts', DepartmentController::class)->except('show')->middleware('role:depts');
                Route::resource('newsletter', NewsletterController::class)->only('index', 'create', 'store', 'destroy')->middleware('role:newsletter');
                Route::resource('users', UserController::class)->except('show')->middleware('role:users');
                Route::resource('admins', AdminsController::class)->except('show')->middleware('role:admins');
                Route::resource('slider', SliderController::class)->except('show')->middleware('role:slider');
                Route::resource('contact', ContactController::class)->only('index', 'edit', 'update', 'destroy')->middleware('role:contact');
                Route::resource('projects', ProjectController::class)->except('show')->middleware('role:projects');
                Route::resource('clients', ClientController::class)->except('show')->middleware('role:clients');
                Route::resource('services', ServiceController::class)->except('show')->middleware('role:services');
                Route::resource('features', FeatureController::class)->except('show')->middleware('role:features');
                Route::resource('calculator', CalculatorItemController::class)->except('show')->middleware('role:calculator');
                Route::resource('requests', CostRequestController::class)->only('index', 'show', 'destroy')->middleware('role:requests');
                Route::resource('invoices', InvoiceController::class)->middleware('role:invoices');

                Route::get('logout', [AdminController::class, 'logout']);
                Route::get('/', [AdminController::class, 'index']);
            });

            Route::group(array('prefix' => 'trika'), function () {
                Route::get('login', [AdminController::class, 'getLogin']);
                Route::post('login', [AdminController::class, 'postLogin']);
                Route::get('not_allow', [AdminController::class, 'not_allow']);
            });

            Route::get('/', [HomeController::class, 'index']);
            Route::get('services', [HomeController::class, 'services']);
            Route::get('government', [HomeController::class, 'government']);
            Route::get('services/{uuid}/{seo?}', [HomeController::class, 'service'])->whereUuid('uuid');
            Route::get('calculator', [CalculatorController::class, 'show']);
            Route::post('calculator', [CalculatorController::class, 'store'])->middleware('throttle:10,1');
            Route::get('news', [HomeController::class, 'news']);
            Route::get('news/{uuid}/{seo?}', [HomeController::class, 'post'])->whereUuid('uuid');
            Route::get('page/{uuid}/{seo?}', [HomeController::class, 'page'])->whereUuid('uuid');
            Route::get('contact', [HomeController::class, 'contactus']);
            Route::post('contact', [HomeController::class, 'contact'])->middleware('throttle:10,1');

            // Old URLs
            Route::get('allservices/{seo?}', fn () => redirect(LaravelLocalization::localizeUrl('services'), 301));
            Route::get('service/{id}/{seo?}', fn ($id) => redirect(LaravelLocalization::localizeUrl('services/'.App\Models\Service::findOrFail((int) $id)->uuid), 301));
            Route::get('allnews/{seo?}', fn () => redirect(LaravelLocalization::localizeUrl('news'), 301));
            Route::get('contactus/{id?}', fn () => redirect(LaravelLocalization::localizeUrl('contact'), 301));
        });
