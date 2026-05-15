<?php

use App\Http\Controllers\Admin\{
    PatientControllerl,
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
    QueController,
    ProjectController,
    AdvController,
    ClientController,
    ServiceController,
    AdminController
};
use App\Http\Controllers\HomeController;

Route::get('reload-captcha', [HomeController::class, 'reloadCaptcha']);

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        ], function () {
            Auth::routes();

            Route::group(array('prefix' => 'admin', 'middleware' => 'admin'), function () {
                Route::resource('patient', PatientControllerl::class)->middleware('role:patient');
                Route::resource('booking', BookingController::class)->middleware('role:booking');
                Route::resource('daily', DailyController::class)->middleware('role:daily');
                Route::resource('opinions', OpinionController::class)->middleware('role:opinion');
                Route::resource('videos', VideoController::class)->middleware('role:video');
                Route::resource('site', SiteController::class)->middleware('role:site');
                Route::resource('groups', GroupController::class)->middleware('role:groups');
                Route::resource('blogs', BlogController::class)->middleware('role:blog');
                Route::resource('news', BlogController::class)->middleware('role:news');
                Route::resource('pages', PagesController::class)->middleware('role:pages');
                Route::resource('depts', DepartmentController::class)->middleware('role:depts');
                Route::resource('newsletter', NewsletterController::class)->middleware('role:newsletter');
                Route::resource('users', UserController::class)->middleware('role:users');
                Route::resource('admins', AdminsController::class)->middleware('role:admins');
                Route::resource('slider', SliderController::class)->middleware('role:slider');
                Route::resource('contact', ContactController::class)->middleware('role:contact');
                Route::resource('ques', QueController::class)->middleware('role:ques');
                Route::resource('projects', ProjectController::class)->middleware('role:projects');
                Route::resource('advantages', AdvController::class)->middleware('role:advantages');
                Route::resource('clients', ClientController::class)->middleware('role:clients');
                Route::resource('services', ServiceController::class)->middleware('role:services');

                Route::get('logout', [AdminController::class, 'logout']);
                Route::get('/', [AdminController::class, 'index']);
            });

            Route::group(array('prefix' => 'admin'), function () {
                Route::get('login', [AdminController::class, 'getLogin']);
                Route::post('login', [AdminController::class, 'postLogin']);
                Route::get('not_allow', [AdminController::class, 'not_allow']);
            });
            Route::get('/', [HomeController::class, 'index']);
            Route::get('lang/{id}', [HomeController::class, 'language']);
            Route::get('allnews/{seo}', [HomeController::class, 'allnews']);
            Route::get('news/{id}/{seo}', [HomeController::class, 'news']);
            Route::get('allservices/{seo}', [HomeController::class, 'allservices']);
            Route::get('service/{id}/{seo}', [HomeController::class, 'service']);
            Route::get('page/{id}/{seo}', [HomeController::class, 'page']);
            Route::get('contactus/{id}', [HomeController::class, 'contactus']);
            Route::post('contactus', [HomeController::class, 'contact']);
        });
