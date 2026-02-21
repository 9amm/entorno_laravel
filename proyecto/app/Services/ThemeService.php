<?php

namespace App\Services;

use App\Contracts\IUsersRepository;
use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;

class ThemeService {

    /**
     * Actualiza el tema de un usuario, guarda los cambios en la bd
     */
    function setTema(bool $modoOscuroActivado, User $usuario, IUsersRepository $repositorioUsuarios) {
        $usuario->setModoOscuroActivado($modoOscuroActivado);
        $repositorioUsuarios->update($usuario);
    }

    /**
     * Crear una cookie con el tema que prefiere el usuario
     */
    function crearCookieParaUsuario(User $usuario): void{
        $clave = "modoOscuroActivado";
        $valor = $usuario->getModoOscuroActivado() ? "true" : "false";
        setcookie($clave, $valor);
    }

}
