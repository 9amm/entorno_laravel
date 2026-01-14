<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use Illuminate\Http\Request;
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
            $usuarioEncontrado = $this->repositorioUsuarios->getByNombre($usuario);

            //si no se ha encontrado un usuario con el nombre introducido en el formulario
            if($usuarioEncontrado != null && $pass == $usuarioEncontrado->passHasheada) {
                $this->authController->setUsuarioLogeado($usuarioEncontrado);

                //buscamos en la bd si este usuario tiene el modo oscuro activado y enviamos al navegador
                //una cookie con el valor obtenido, luego desde js podemos leer el valor de la cookie y cambiar
                //los colores de la pagina dependiendo de si el modo oscuro esta activado o no
                setcookie("modoOscuroActivado", $usuarioEncontrado->getModoOscuroActivado() ? "true":"false");
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

}
