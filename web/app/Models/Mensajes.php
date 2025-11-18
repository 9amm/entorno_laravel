<?php


class Mensajes {
    private JsonDb $archivoMensajes;

    function __construct() {
        $this->archivoMensajes = new JsonDb(JsonDb::MENSAJES);
        $contenidoArchivo = $this->archivoMensajes->leer();
        
        if(!isset($contenidoArchivo["ultimoId"]) || !isset($contenidoArchivo["mensajes"])) {
            $this->archivoMensajes->escribir([
                "ultimoId" => 0,
                "mensajes" => []
            ]);
        }
    }
    
    /**
     * @return array un array de objetos Mensaje
     */
    function getAll(): array {

        $resultado = [];
        $mensajes = $this->archivoMensajes->leer()["mensajes"];

        foreach($mensajes as $mensaje) {
            array_push($resultado, $this->arrayAMensaje($mensaje));
        }
        
        return $resultado;
    }



    function save(Mensaje $mensaje): void {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $mensaje->id = ++$contenidoArchivo["ultimoId"];
        $contenidoArchivo["mensajes"][$mensaje->id] = $mensaje;

        $this->archivoMensajes->escribir((array) $contenidoArchivo);
    }


    function update(Mensaje $mensaje) {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $contenidoArchivo["mensajes"][$mensaje->id] = $mensaje;
        $this->archivoMensajes->escribir((array) $contenidoArchivo);
    }



    function getById($id): ?Mensaje {
        $contenidoArchivo = $this->archivoMensajes->leer();
        $mensajeEncontrado = $contenidoArchivo["mensajes"][$id] ?? null;

        if($mensajeEncontrado == null) {
            return null;
        }

        return $this->arrayAMensaje($mensajeEncontrado);
    }


    /**
     * Devuelve un array con todos los mensajes que ha publicado el usuario que
     * se pase como parametro
     * @return array un array de objetos Mensaje
     */
    function getByUser(User $usuario): array {
        $mensajesUsuario = [];
        $todosMensajes = $this->getAll();

        foreach($todosMensajes as $mensaje) {
            if($mensaje->idUsuario == $usuario->id) {
                array_push($mensajesUsuario, $mensaje);
            }
        }

        return $mensajesUsuario;
    }


    /**
     * Devuelve todos los mensajes con el estado que se pase como parametro
     * @see EstadosMensaje
     */
    function getByEstado(string $estado): array {
        $resultado = [];
        $mensajes = $this->getAll();

        foreach($mensajes as $mensaje) {
            if($mensaje->estadoMensaje == $estado) {
                array_push($resultado, $mensaje);
            }
        }

        return $resultado;
    }

    /**
     * a partir del id de una asignatura devuelve un array con todos los mensajes
     * que existen sobre esa asignatura, sin importar su estado
     */
    function getByAsignatura(int $idAsignatura): array {
        $resultado = [];
        $mensajes = $this->getAll();

        foreach($mensajes as $mensaje) {
            if($mensaje->idAsignatura == $idAsignatura) {
                array_push($resultado, $mensaje);
            }
        }

        return $resultado;
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