<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use App\Services\LoginService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller {

    function show() : View {
        return view("login");
    }

    function login(Request $peticion, LoginService $loginService, ThemeService $themeService) {
        $usuario = $peticion->input("usuario", "");

        //la contraseña que se envia hasheada desde el frontend
        $pass = $peticion->input("pass", "");

        $respuesta = null;


        if(!empty($usuario) && !empty($pass)) {
            $usuarioLogueado = $loginService->login($usuario, $pass);

            if($usuarioLogueado != null) {
                $themeService->crearCookieParaUsuario($usuarioLogueado);

                $peticion->session()->regenerate();
                $respuesta = redirect()->intended();
            } else {
                $respuesta = view("alerta_auth", ["mensaje" => "Datos de inicio de sesión no válidos"]);
            }

        } else {
            $respuesta = view("alerta_auth", ["mensaje" => "Cubre todos los campos"]);
        }

        return $respuesta;
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
