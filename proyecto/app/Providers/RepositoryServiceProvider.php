<?php

namespace App\Providers;

use App\Contracts\IMensajesRepository;
use App\Contracts\IUsersRepository;
use App\Repositories\JsonDb;
use App\Repositories\MensajesJsonRepository;
use App\Repositories\UsersJsonRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {
        $this->app->bind(IUsersRepository::class, function ($app) {
            return new UsersJsonRepository();
        });

        $this->app->bind(IMensajesRepository::class, function ($app) {
            return new MensajesJsonRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
    }
}
