<?php

namespace App\Providers;

use App\Contracts\IAsignaturasRepository;
use App\Contracts\IMensajesRepository;
use App\Contracts\IUsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

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

        Route::bind('asignatura', function (string $idAsignatura) {
            $repositorioAsignaturas = $this->app->make(IAsignaturasRepository::class);
            $asignaturaEncontrada =  $repositorioAsignaturas->getById($idAsignatura);

            $respuesta = null;
            if($asignaturaEncontrada != null) {
                $respuesta = $asignaturaEncontrada;
            } else {
                $respuesta = abort(404);
            }
            return $respuesta;
        });

        Route::bind('mensaje', function (string $idMensaje) {
            $repositorioMensajes = $this->app->make(IMensajesRepository::class);
            $mensajeEncontrado = $repositorioMensajes->getById($idMensaje);

            $respuesta = null;
            if($mensajeEncontrado != null) {
                $respuesta = $mensajeEncontrado;
            } else {
                $respuesta = abort(404);
            }
            return $respuesta;
        });

    }
}
