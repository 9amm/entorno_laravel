<?php


namespace App\Repositories;
use App\Contracts\IAsignaturasRepository;
use App\Models\Asignatura;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class AsignaturasMariaDBRepository implements IAsignaturasRepository{


    function getAll(): array {
        $asignaturas =  DB::table("asignatura")->get();
        return $this->collectionAAsignaturas($asignaturas);
    }


    function getById($id): ?Asignatura {
        $asignaturaEncontrada = DB::table('asignatura')->find($id);

        if($asignaturaEncontrada != null) {
            $asignaturaEncontrada = $this->crearAsignatura($asignaturaEncontrada);
        }

        return $asignaturaEncontrada;

    }

    function save(Asignatura $asignatura): void {
        DB::table('asignatura')->insert([
            "id" => null,
            "nombre" => $asignatura->nombre 
        ]);
    }

    function delete(int $idAsignatura): bool {
        $numFilasBorradas = DB::table("mensaje")->where("id", $idAsignatura)->delete();

        return $numFilasBorradas != 0;
    }

    private function crearAsignatura(stdClass $asignatura): Asignatura {
        return new Asignatura(
            $asignatura->nombre,
            $asignatura->id
        );
    }
    private function collectionAAsignaturas(Collection $asignatura): array {
        return $asignatura->map(fn($asignatura) => $this->crearAsignatura($asignatura), $asignatura)->toArray();
    }
}

?>