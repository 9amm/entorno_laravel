<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\View\View;


class RegisterController extends Controller {

    protected $RegisterService;

    public function __construct(RegisterService $RegisterService) {
        $this->RegisterService = $RegisterService;
    }

    function show() : View {
        return view("register");
    }


    function register(Request $peticion, IUsersRepository $repositorioUsuarios) {
    $resultado = $this->RegisterService->register([
        "nombreUsuario" => $peticion->input("nombre", ""),
        "email" => $peticion->input("email", ""),
        "pass" => $peticion->input("pass", ""),
        "rol" => $peticion->input("rol", ""),
    ], $repositorioUsuarios);

        if($resultado) {
            return view("alerta_auth", ["mensaje" => $resultado]);
        }
        return redirect()->route("inicio");
    }
}