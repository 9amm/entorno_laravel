<?php

namespace App\Models;

use IMensajesRepository;
use MensajesJsonRepository;

class Asignatura {
    public ?int $id;
    public string $nombre;

    function __construct(string $nombre, ?int $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
    }


    /**
     * @return array devuelve un array con los objetos mensajes de esta asignatura
     * sin importar su estado
     */
    function getMensajes(): array {
        return $this->repositorio->getByAsignatura($this->id);
    }

    /**
     * @return array devuelve un array con todos los objetos mensaje de esta
     * asignatura que tienen el estado que se pase como parametro
     * @see EstadosMensaje
     */
    function getMensajesPorEstado(string $estado): array {
        $mensajesEstaAsignatura = $this->getMensajes();
        return array_filter($mensajesEstaAsignatura, fn($mensaje) => $mensaje->tieneEstado($estado));
    }
}


?>