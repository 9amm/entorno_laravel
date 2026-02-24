<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginService {

    protected $themeService;

    public function __construct(ThemeService $themeService) {
        $this->themeService = $themeService;
    }

    /**
     * @return bool si se ha podido iniciar sesion
     */
    public function login($nombreUsuario, $passHasheada): ?User {
        $credencialesValidas = Auth::attempt([
            "usuario" => $nombreUsuario,
            "pass" => $passHasheada
        ]);

        $usuario = null;

        if($credencialesValidas) {
            $usuario = Auth::user();

            $this->themeService->crearCookieParaUsuario($usuario);
            session()->regenerate();
        } 

        return $usuario;

    }
}
