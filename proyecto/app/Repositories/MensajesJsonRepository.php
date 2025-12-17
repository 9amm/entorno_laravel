<?php


class MensajesJsonRepository implements IMensajesRepository{
    private JsonDb $archivoMensajes;

    function __construct() {
        $this->archivoMensajes = new JsonDb(JsonDb::MENSAJES);
        
    }
    
    function getAll(): array {
        $mensajes = $this->archivoMensajes->leer()["items"];
        return array_map(fn($mensaje) => $this->arrayAMensaje($mensaje), $mensajes);
    }



    function save(Mensaje $mensaje): void {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $mensaje->id = ++$contenidoArchivo["ultimoId"];
        $contenidoArchivo["items"][$mensaje->id] = $mensaje;

        $this->archivoMensajes->escribir((array) $contenidoArchivo);
    }


    function update(Mensaje $mensaje) {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $contenidoArchivo["items"][$mensaje->id] = $mensaje;
        $this->archivoMensajes->escribir((array) $contenidoArchivo);
    }



    function getById($id): ?Mensaje {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $mensajeEncontrado = $contenidoArchivo["items"][$id] ?? null;

        if($mensajeEncontrado == null) {
            return null;
        }

        return $this->arrayAMensaje($mensajeEncontrado);
    }



    function getByUser(User $usuario): array {
        $todosMensajes = $this->getAll();

        return array_filter($todosMensajes, fn($mensaje) => $mensaje->idUsuario == $usuario->id);
    }


    function getByEstado(string $estado): array {
        $mensajes = $this->getAll();

        return array_filter($mensajes, fn($mensaje) => $mensaje->estadoMensaje == $estado);
    }

    function getByEstados(array $estados): array {
        $mensajes = $this->getAll();

        return array_filter($mensajes,fn($mensaje) => 
            $mensaje->tieneAlgunoDeLosEstados($estados)
        );
    }


    function getByAsignatura(int $idAsignatura): array {
        $mensajes = $this->getAll();

        return array_filter($mensajes, fn($mensaje) => $mensaje->idAsignatura == $idAsignatura);
    }


    //TODO: mover esto a la clase mensaje, que tenga un metodo estatico tipo fromArray,
    //tiene mas sentido que que este aqui
    private function arrayAMensaje(array $mensaje): Mensaje {
        return new Mensaje(
            $mensaje["contenido"],
            $mensaje["idAsignatura"],
            $mensaje["idUsuario"],
            $mensaje["estadoMensaje"],
            $mensaje["timestampCreacion"],
            $mensaje["id"]
        );
    }

}

?>