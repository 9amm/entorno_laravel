<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller {
    protected IUsersRepository $repositorioUsuarios;
    protected AuthController $authController;

    function __construct(IUsersRepository $repositorioUsuarios, AuthController $authController) {
        $this->repositorioUsuarios = $repositorioUsuarios;
        $this->authController = $authController;
    }

    function show() : View {
        return view("login");
    }

    function login(Request $peticion) {
        $usuario = $peticion->input("usuario", "");

        //la contraseña que se envia hasheada desde el frontend
        $pass = $peticion->input("pass", "");

        $respuesta = null;


        if(!empty($usuario) && !empty($pass)) {

            $datosLogin =[
                "usuario" => $usuario,
                "pass" => $pass
            ];

            if(Auth::attempt($datosLogin)) {
                //los colores de la pagina dependiendo de si el modo oscuro esta activado o no
                setcookie("modoOscuroActivado", $peticion->user()->getModoOscuroActivado() ? "true":"false");
                $peticion->session()->regenerate();

                $rutaRedirigir = $peticion->session()->get("origenRedireccion", "") ?? "/";
                $respuesta = redirect($rutaRedirigir);

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
