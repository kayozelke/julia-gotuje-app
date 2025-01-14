<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share top categories with the header view
        View::composer('front.header', function ($view) {
            $main_categories = Category::whereNull('parent_id')->orderBy('name')->get();
            $view->with('main_categories', $main_categories);
        });

        // Share top categories with the footer view
        View::composer('front.footer', function ($view) {
            $main_categories = Category::whereNull('parent_id')->orderBy('name')->get();
            $view->with('main_categories', $main_categories);
        });

        // Share general settings with the footer view
        View::composer('front.footer', function ($view) {
            $generalSettings = GeneralSetting::all();
            $view->with('generalSettings', $generalSettings);
        });
    }
}
