<?php

namespace App\Providers;

use App\Repositories\FavouriteCountryRepository;
use App\Repositories\FavouriteCountryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            FavouriteCountryRepositoryInterface::class,
            FavouriteCountryRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
