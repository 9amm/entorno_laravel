<?php

namespace App\Services;

use App\Contracts\IUsersRepository;

class ThemeService {

    /**
     * Para cada cuenta de la red social guardamos que tema prefiere,
     * si prefiere modo claro o prefiere modo oscuro.
     * 
     * El usuario puede cambiar el tema desde la interfaz, cuando lo haga
     * necesitamos guardar ese cambio en el servidor para que cuando inicie
     * sesion desde otros dispositivos la web se muestre con el tema seleccionado.
     * 
     * Esta funcion es la que se encarga de guardar el nuevo cambio de tema en el servidor,
     * lee los datos que se envian en el cuerpo de la peticion POST, valida que cumpan
     * un formato y los guarda.
     */
    function setTema($modoOscuroActivado, $usuario, IUsersRepository $repositorioUsuarios) {

        if ($modoOscuroActivado != "true" && $modoOscuroActivado != "false") {
            echo("valor no valido");
        } else {
            $usuario->setModoOscuroActivado($modoOscuroActivado == "true");
            $repositorioUsuarios->update($usuario);
        }
    
    }

}
