<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        View::composer('partials.header', function ($view) {
            $view->with('top_categories', Category::whereNull('parent_id')->orderBy('name')->get());
        });
    }
}
