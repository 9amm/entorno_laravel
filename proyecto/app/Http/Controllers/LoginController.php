<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller {

    function show() : View {
        return view("login");
    }

    function login(LoginRequest $peticion, LoginService $loginService) {
        $respuesta = null;

        $usuarioLogueado = $loginService->login(
            $peticion->validated("usuario"),
            $peticion->validated("pass")
        );

        $credencialesValidas = $usuarioLogueado != null;

        if($credencialesValidas) {
            $respuesta = redirect()->intended();
        } else {
            $respuesta = view("alerta_auth", ["mensaje" => "Datos de inicio de sesión no válidos"]);
        }

        return $respuesta;
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
