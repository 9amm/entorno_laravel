<?php

namespace App\Http\Middleware;

use App\Contracts\IUsersRepository;
use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Autenticar {
    private IUsersRepository $repositorioUsuarios;

    function __construct(IUsersRepository $repositorioUsuarios) {
        $this->repositorioUsuarios = $repositorioUsuarios;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $authController = new AuthController($this->repositorioUsuarios);
        $respuesta = null;

        if(!$authController->usuarioEstaLogueado()) {
            $respuesta = redirect()->route("login");
        } else {
            $respuesta = $next($request);
        }

        return $respuesta;
    }
}
