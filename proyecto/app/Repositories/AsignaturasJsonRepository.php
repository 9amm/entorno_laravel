<?php


namespace App\Repositories;
use App\Contracts\IAsignaturasRepository;
use App\Models\Asignatura;


class AsignaturasJsonRepository implements IAsignaturasRepository{
    private JsonDb $archivoAsignaturas;


    function __construct() {
        $this->archivoAsignaturas = new JsonDb(JsonDb::ASIGNATURAS);

    }


    function getAll(): array {
        $asignaturas = $this->archivoAsignaturas->leer()["items"];

        return array_map(fn($asignatura) => $this->arrayAAsignatura($asignatura), $asignaturas);
    }


    function getById($id): ?Asignatura {
        $contenidoArchivo = $this->archivoAsignaturas->leer();
        $asignaturaEncontrada = $contenidoArchivo["items"][$id] ?? null;

        if($asignaturaEncontrada == null) {
            return null;
        }

        return $this->arrayAAsignatura($asignaturaEncontrada);
    }

    function save(Asignatura $asignatura): void {
        $contenidoArchivo = $this->archivoAsignaturas->leer();
        $asignatura->id = ++$contenidoArchivo["ultimoId"];
        $contenidoArchivo["items"][$asignatura->id] = $asignatura;

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