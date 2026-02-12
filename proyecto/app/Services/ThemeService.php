<?php

namespace App\Services;

use App\Contracts\IUsersRepository;
use App\Models\User;

class ThemeService {

    /**
     * Actualiza el tema de un usuario, guarda los cambios en la bd
     */
    function setTema(bool $modoOscuroActivado, User $usuario, IUsersRepository $repositorioUsuarios) {
        $usuario->setModoOscuroActivado($modoOscuroActivado);
        $repositorioUsuarios->update($usuario);
    }

}
