<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Kecamatan;
use App\Services\SpamDetectionService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SpamDetectionService::class, function ($app) {
            return new SpamDetectionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function($view) {
        $view->with('kecamatans', Kecamatan::orderBy('nama')->get());
    });
    }
}
