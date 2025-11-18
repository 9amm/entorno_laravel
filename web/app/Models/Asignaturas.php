<?php

class Asignaturas {
    private JsonDb $archivoAsignaturas;


    function __construct() {
        $this->archivoAsignaturas = new JsonDb(JsonDb::ASIGNATURAS);
        $contenidoArchivo = $this->archivoAsignaturas->leer();

        if(!isset($contenidoArchivo["ultimoId"]) || !isset($contenidoArchivo["asignaturas"])) {
            $this->archivoAsignaturas->escribir([
                "ultimoId" => 0,
                "asignaturas" => []
            ]);
        }
    }


    function getAll(): array {
        $resultado = [];
        $asignaturas = $this->archivoAsignaturas->leer()["asignaturas"];

        foreach($asignaturas as $asignatura) {
            array_push($resultado, $this->arrayAAsignatura($asignatura));
        }
        
        return $resultado;
    }


    function getById($id): ?Asignatura {
        $contenidoArchivo = $this->archivoAsignaturas->leer();
        $asignaturaEncontrada = $contenidoArchivo["asignaturas"][$id] ?? null;

        if($asignaturaEncontrada == null) {
            return null;
        }

        return $this->arrayAAsignatura($asignaturaEncontrada);
    }

    function save(Asignatura $asignatura): void {
        $contenidoArchivo = $this->archivoAsignaturas->leer();
        $asignatura->id = ++$contenidoArchivo["ultimoId"];
        $contenidoArchivo["asignaturas"][$asignatura->id] = $asignatura;

        $this->archivoAsignaturas->escribir((array) $contenidoArchivo);
    }


    private function arrayAAsignatura(array $asignatura): Asignatura {
        return new Asignatura(
            $asignatura["nombre"],
            $asignatura["id"]
        );
    }
}

?>