<?php
namespace App\Services;

use App\Models\User;
use App\Contracts\IUsersRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class RegisterService{
    protected IUsersRepository $repositorioUsuarios;

    public function __construct(IUsersRepository $repositorioUsuarios) {
        $this->repositorioUsuarios = $repositorioUsuarios;
    }
    
    function register($nombreUsuario, $email, $passHasheada, $rol, StatefulGuard|JWTGuard $guard){
        $mensaje = "";

        $nombreDisponible = $this->repositorioUsuarios->getByNombre($nombreUsuario) == null;

        if($nombreDisponible) {
            $emailDisponible = $this->repositorioUsuarios->getByEmail($email) == null;

            if($emailDisponible) {
                $nuevoUsuario = new User($nombreUsuario, $email, $passHasheada, $rol);
                $usuarioInsertado = $this->repositorioUsuarios->save($nuevoUsuario);
                $guard->login($usuarioInsertado);
            } else {
                $mensaje = "Email no válido";
            }
        } else {
            $mensaje = "Nombre de usuario no disponible";
        }

        return $mensaje;
    }
}