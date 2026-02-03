<?php


namespace App\Repositories;
use App\Contracts\IAsignaturasRepository;
use App\Models\Asignatura;
use Illuminate\Support\Facades\DB;
use stdClass;

class AsignaturasMariaDBRepository implements IAsignaturasRepository{


    function getAll(): array {
        $asignaturas =  DB::select("select * from asignatura");

        return array_map(fn($asignatura) => $this->arrayAAsignatura($asignatura), $asignaturas);
    }


    function getById($id): ?Asignatura {
        $asignaturaEncontrada = DB::select("select * from asignatura where id = ?", [$id])[0] ?? null;

        if($asignaturaEncontrada != null) {
            $asignaturaEncontrada = $this->arrayAAsignatura($asignaturaEncontrada);
        }

        return $asignaturaEncontrada;    
    }

    function save(Asignatura $asignatura): void {
        $asignatura = [
            //autoincremental
            "id" => null,
            "nombre" => $asignatura->nombre
        ];
        DB::insert("insert into `asignatura` (`id`, `nombre`) values (:id, :nombre); ", $asignatura);
    }


    private function arrayAAsignatura(stdClass $asignatura): Asignatura {
        return new Asignatura(
            $asignatura->nombre,
            $asignatura->id
        );
    }
}

?>