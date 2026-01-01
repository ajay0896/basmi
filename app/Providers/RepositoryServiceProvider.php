<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\LaporanRepositoryInterface;
use App\Repositories\LaporanRepository;
use App\Interfaces\AduanRepositoryInterface;
use App\Interfaces\DesaRepositoryInterface;
use App\Repositories\AduanRepository;
use App\Repositories\DesaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LaporanRepositoryInterface::class, LaporanRepository::class);
        $this->app->bind(AduanRepositoryInterface::class, AduanRepository::class);
        $this->app->bind(DesaRepositoryInterface::class, DesaRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}