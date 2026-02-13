<?php

namespace App\Services;

use App\Contracts\IMensajesRepository;
use App\Models\Asignatura;
use App\Models\EstadosMensaje;
use App\Models\User;
use App\Models\Mensaje;

class MessageService {

    /**
     * Crea un nuevo mensaje asociado a un autor y a una asignatura, el mensaje
     * se guarda en la bd.
     * 
     * @param User autor el usuario que escribio el mensaje
     * @param Asignatura asignatura la asignatura sobre la que trata el mensaje
     * @param IMensajesRepository repoMensajes donde se va a guardar el mensaje
     * @see IMensajesRepository
     */
    public function guardar(string $contenidoMensaje, User $autor, Asignatura $asignatura, IMensajesRepository $repoMensajes): Mensaje {
        $estado = Mensaje::calcularEstadoMensaje($contenidoMensaje);

        $mensaje = new Mensaje(
            contenido: $contenidoMensaje,
            idAsignatura: $asignatura->id,
            idUsuario: $autor->id,
            estadoMensaje: $estado,
            timestampCreacion: time()
        );

        //guardamos el mensaje en la bd
        $repoMensajes->save($mensaje);

        return $mensaje;
    }
}
