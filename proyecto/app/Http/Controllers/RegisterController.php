<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use App\Models\Rol;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class RegisterController extends Controller {


    public function __construct() {
        //throw new \Exception('Not implemented');
    }

    function show() : View {
        return view("register");
    }


    function register(Request $peticion, IUsersRepository $repositorioUsuarios, AuthController $authController) {


        //$usuario = $peticion->input("usuario", "");

        //obtenemos los datos que se envian desde el formulario
        $nombreUsuario = $peticion->input("nombre", "");
        $email = $peticion->input("email", "");
        $pass = $peticion->input("pass", "");
        $rol = $peticion->input("rol", "");


        $respuesta = null;

        //comprobamos si se han enviado todos los campos del formulario
        if(empty($nombreUsuario) || empty($email) || empty($pass)) {
            $respuesta = view("alerta_auth", ["mensaje" => "Todos los campos son obligatorios"]);

        } else if(!Utils::nombreCumpleFormato($nombreUsuario)) {
            $respuesta = view("alerta_auth", ["mensaje" => "Nombre de usuario no cumple formato"]);

        } else if(!Utils::emailCumpleFormato($email)) {
            $respuesta = view("alerta_auth", ["mensaje" => "Email no válido"]);

        } else if($rol != Rol::ALUMNO && $rol != Rol::PROFESOR) {
            $respuesta = view("alerta_auth", ["mensaje" => "Rol no válido"]);
        } else {

            //comprobamos que el nombre de usuario no lo este utilizando otro usuario
            //$archivoUsuarios = $repositorioUsuarios;

            //si encontramos en la bd a alguien con ese nombre significa que esta ocupado
            $nombreDisponible = $repositorioUsuarios->getByNombre($nombreUsuario) == null;

            if($nombreDisponible) {

                //comprobamos si hay un usuario en la bd con ese email
                $emailDisponible = $repositorioUsuarios->getByEmail($email) == null;

                //mensaje generico para no dar informacion sobre que emails hay registrados
                if($emailDisponible) {

                    if(Utils::contrasenaHasheadaCumpleFormato($pass)) {
                        //si llega hasta este punto los datos son validos, guardamos el usuario en bd


                        //creamos un usuario con los datos del formluario
                        $nuevoUsuario = new User($nombreUsuario, $email, $pass, $rol);
                        //guardamos el usuario en la bd
                        $repositorioUsuarios->save($nuevoUsuario);


                        //guardamos en la sesion el usuario que se acaba de crear para que en la
                        //proximas peticiones no se le pida iniciar sesion
                        Auth::login($nuevoUsuario);
                        return redirect()->route("inicio");

                    } else {
                        $respuesta = view("alerta_auth", ["mensaje" => "La contraseña no cumple con el formato solicitado"]);
                    }

                } else {
                    $respuesta = view("alerta_auth", ["mensaje" => "Email no válido"]);
                }

            } else {
                $respuesta = view("alerta_auth", ["mensaje" => "Nombre de usuario no disponible"]);
            }
        }

        return $respuesta;
    }




}