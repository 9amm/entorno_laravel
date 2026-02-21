<?php
namespace App\Services;

use App\Models\User;
use App\Contracts\IUsersRepository;
use Illuminate\Support\Facades\Auth;

class RegisterService{
    public function __construct() {
    }
    
    function register($nombreUsuario, $email, $passHasheada, $rol, IUsersRepository $repositorioUsuarios){
        $mensaje = "";

        $nombreDisponible = $repositorioUsuarios->getByNombre($nombreUsuario) == null;

        if($nombreDisponible) {
            $emailDisponible = $repositorioUsuarios->getByEmail($email) == null;

            if($emailDisponible) {
                $nuevoUsuario = new User($nombreUsuario, $email, $passHasheada, $rol);
                $usuarioInsertado = $repositorioUsuarios->save($nuevoUsuario);
                Auth::login($usuarioInsertado);
            } else {
                $mensaje = "Email no válido";
            }
        } else {
            $mensaje = "Nombre de usuario no disponible";
        }

        return $mensaje;
    }
}