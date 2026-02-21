<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\View\View;


class RegisterController extends Controller {

    function show() : View {
        return view("register");
    }


    function register(RegisterRequest $peticion, IUsersRepository $repositorioUsuarios, RegisterService $registerService) {
        $mensajeError = $registerService->register(
            $peticion->validated("nombre"),
            $peticion->validated("email"),
            $peticion->validated("pass"),
            $peticion->validated("rol"),
            $repositorioUsuarios
        );

        $respuesta = null;

        if($mensajeError) {
            $respuesta = view("alerta_auth", ["mensaje" => $mensajeError]);
        } else {
            $respuesta = redirect()->route("inicio");
        }

        return $respuesta;
    }
}