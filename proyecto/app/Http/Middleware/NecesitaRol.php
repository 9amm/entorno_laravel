<?php

namespace App\Http\Middleware;

use App\Contracts\IUsersRepository;
use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NecesitaRol {
    private IUsersRepository $repositorioUsuarios;

    function __construct(IUsersRepository $repositorioUsuarios) {
        $this->repositorioUsuarios = $repositorioUsuarios;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response {
        $authController = new AuthController($this->repositorioUsuarios, $request);
        $respuesta = null;

        $usuarioLogeado = $authController->getUsuarioLogeado();

        if(!$usuarioLogeado->tieneRol($rol)) {
            $respuesta = redirect()->route("inicio");
        } else {
            $respuesta = $next($request);
        }

        return $respuesta;
    }
}
