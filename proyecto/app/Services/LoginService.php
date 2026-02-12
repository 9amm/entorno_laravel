<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginService {

    /**
     * @return bool si se ha podido iniciar sesion
     */
    public function login($nombreUsuario, $passHasheada): ?User {
        $datosLogin = [
            "usuario" => $nombreUsuario,
            "pass" => $passHasheada
        ];

        return Auth::attempt($datosLogin) ? Auth::user() : null;

    }
}
