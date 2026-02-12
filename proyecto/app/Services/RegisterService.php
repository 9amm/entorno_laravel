<?php
namespace App\Services;

use App\Models\Rol;
use App\Models\User;
use App\Utils\Utils;
use App\Contracts\IUsersRepository;
use Illuminate\Support\Facades\Auth;

class RegisterService{
    public function __construct() {}
    
    function register(array $datos, IUsersRepository $repositorioUsuarios){
        $mensaje = "";
        if(empty($datos["nombreUsuario"]) || empty($datos["email"]) || empty($datos["pass"])) {
            $mensaje = "Todos los campos son obligatorios";
        } else if(!Utils::nombreCumpleFormato($datos["nombreUsuario"])) {
            $mensaje = "Nombre de usuario no cumple formato";
        } else if(!Utils::emailCumpleFormato($datos["email"])) {
            $mensaje = "Email no válido";
        } else if($datos["rol"] != Rol::ALUMNO && $datos["rol"] != Rol::PROFESOR) {
            $mensaje = "Rol no válido";
        } else {
            $nombreDisponible = $repositorioUsuarios->getByNombre($datos["nombreUsuario"]) == null;
            if($nombreDisponible) {
                $emailDisponible = $repositorioUsuarios->getByEmail($datos["email"]) == null;

                if($emailDisponible) {
                    if(Utils::contrasenaHasheadaCumpleFormato($datos["pass"])) {
                        $nuevoUsuario = new User($datos["nombreUsuario"], $datos["email"], $datos["pass"], $datos["rol"]);
                        $usuarioInsertado = $repositorioUsuarios->save($nuevoUsuario);
                        Auth::login($usuarioInsertado);
                    } else {
                        $mensaje = "La contraseña no cumple con el formato solicitado";
                    }
                } else {
                    $mensaje = "Email no válido";
                }
            } else {
                $mensaje = "Nombre de usuario no disponible";
            }
        }
        if($mensaje) {
            return $mensaje;
        }
    }
}