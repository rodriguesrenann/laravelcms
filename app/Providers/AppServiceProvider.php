<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use App\Models\Page;
use App\Models\Setting;

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
        Paginator::useBootstrap();
        //-------//
        
        //Pegar settings
        $settings = [];
        $settingsQuery = Setting::all();
        foreach($settingsQuery as $item) {
            $settings[$item['name']] = $item['content'];
        }
        View::share('settingsInfo', $settings);

        //Pegar paginas
        $pages = Page::all();
        $frontMenu = [];
        foreach($pages as $page) {
            $frontMenu [$page['slug']] = $page['title'];
        }
        View::share('frontMenu', $frontMenu);
    }
}
