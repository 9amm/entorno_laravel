<?php

namespace App\Http\Middleware;

use App\Contracts\IUsersRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NecesitaRol {
    private IUsersRepository $repositorioUsuarios;

    function __construct(IUsersRepository $repositorioUsuarios) {
        $this->repositorioUsuarios = $repositorioUsuarios;
    }


    /**
     * Comprueba que el usuario logueado tenga el rol que se pase como parametro,
     * si no lo tiene se muestra la pagina de no encontrado (404)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response {
        $respuesta = null;

        $usuarioLogeado = $request->user();

        if(!$usuarioLogeado->tieneRol($rol)) {
            $respuesta = abort(404);
        } else {
            $respuesta = $next($request);
        }

        return $respuesta;
    }
}
