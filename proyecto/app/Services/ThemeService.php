<?php

namespace App\Services;

use App\Contracts\IUsersRepository;
use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;

class ThemeService {
    protected IUsersRepository $repositorioUsuarios;

    public function __construct(IUsersRepository $repositorioUsuarios) {
       $this->repositorioUsuarios = $repositorioUsuarios;
    }

    /**
     * Actualiza el tema de un usuario, guarda los cambios en la bd
     */
    function setTema(bool $modoOscuroActivado, User $usuario) {
        $usuario->setModoOscuroActivado($modoOscuroActivado);
        $this->repositorioUsuarios->update($usuario);
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
