<?php

namespace App\Providers;

use App\Contracts\IUsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;


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
    public function boot(): void {

        Auth::provider('usuarios_provider', function (Application $app, array $config) {
            return new UsuarioProvider($app->make(IUsersRepository::class));
        });


    }
}
