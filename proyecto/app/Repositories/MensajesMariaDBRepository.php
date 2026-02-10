<?php

namespace App\Repositories;

use App\Contracts\IMensajesRepository;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class MensajesMariaDBRepository implements IMensajesRepository{

    function getAll(): array {
        $mensajes =  DB::table("mensaje")->get();
        return $this->collectionAMensajes($mensajes);
    }



    function save(Mensaje $mensaje): void {
        DB::table("mensaje")
            ->insert([
                "id" => $mensaje->id,
                "contenido" => $mensaje->contenido,
                "id_asignatura" => $mensaje->idAsignatura,
                "id_usuario" => $mensaje->idUsuario,
                "estado_mensaje" => $mensaje->estadoMensaje,
                "timestamp_creacion" => $mensaje->timestampCreacion, 
           ]);
    }


    function update(Mensaje $mensaje) {
        DB::table("mensaje")
            ->where("id", $mensaje->id)
            ->update([
                "id" => $mensaje->id,
                "contenido" => $mensaje->contenido,
                "id_asignatura" => $mensaje->idAsignatura,
                "id_usuario" => $mensaje->idUsuario,
                "estado_mensaje" => $mensaje->estadoMensaje,
                "timestamp_creacion" => $mensaje->timestampCreacion,
            ]);
    }



    function getById($id): ?Mensaje {
        $mensajeEncontrado = DB::table('mensaje')->find($id);

        if($mensajeEncontrado != null) {
            $mensajeEncontrado = $this->crearMensaje($mensajeEncontrado);
        }

        return $mensajeEncontrado;
    }



    function getByUser(User $usuario): array {
        $mensajes = DB::table("mensaje")
            ->where("id_usuario", $usuario->id)
            ->get();

        return $this->collectionAMensajes($mensajes);
    }


    function getByEstado(string $estado): array {
        $mensajes = DB::table("mensaje")
            ->where('estado_mensaje', $estado)
            ->get();

        return $this->collectionAMensajes($mensajes);
    }

    function getByEstados(array $estados): array {
        $mensajes = DB::table("mensaje")
            ->whereIn('estado_mensaje', $estados)
            ->get();

        return $this->collectionAMensajes($mensajes);
    }

    function getByAsignatura(int $idAsignatura): array {
        $mensajes = DB::table("mensaje")
            ->where('id_asignatura', $idAsignatura)
            ->get();

        return $this->collectionAMensajes($mensajes);
    }


    //TODO: mover esto a la clase mensaje, que tenga un metodo estatico tipo fromArray,
    //tiene mas sentido que que este aqui
    private function crearMensaje(stdClass $mensaje): Mensaje {
        return new Mensaje(
            $mensaje->contenido,
            $mensaje->id_asignatura,
            $mensaje->id_usuario,
            $mensaje->estado_mensaje,
            $mensaje->timestamp_creacion,
            $mensaje->id
        );
    }

    private function collectionAMensajes(Collection $mensajes): array {
        return $mensajes->map(fn($mensaje) => $this->crearMensaje($mensaje), $mensajes)->toArray();
    }

}

?>