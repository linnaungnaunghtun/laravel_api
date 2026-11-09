<?php

namespace App\Providers;

use App\Models\Stock;
use App\Observers\StockObserver;
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
        if (!app()->environment('local')) {
            $this->app['request']->server->set('HTTPS', 'on');
        }
        Stock::observe(StockObserver::class);
    }
}
