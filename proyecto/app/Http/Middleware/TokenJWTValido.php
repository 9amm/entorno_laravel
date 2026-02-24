<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenJWTValido {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        $usuarioLogeado = auth("api")->user();

        $respuesta = null;

        if($usuarioLogeado == null) {
            $respuesta = response()->json([
                "success" => false,
                "message" => "proporciona un token válido"
            ], 401);
        } else {
            $respuesta = $next($request);
        }

        return $respuesta;
    }
}
