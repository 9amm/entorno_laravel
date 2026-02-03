<?php

namespace App\Providers;

use App\Contracts\IAsignaturasRepository;
use App\Contracts\IMensajesRepository;
use App\Contracts\IUsersRepository;
use App\Repositories\AsignaturasMariaDBRepository;
use App\Repositories\MensajesJsonRepository;
use App\Repositories\UsersMariaDBRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {
        $this->app->bind(IUsersRepository::class, function ($app) {
            return new UsersMariaDBRepository();
        });

        $this->app->bind(IMensajesRepository::class, function ($app) {
            return new MensajesJsonRepository();
        });

        $this->app->bind(IAsignaturasRepository::class, function ($app) {
            return new AsignaturasMariaDBRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
    }
}
