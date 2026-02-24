<?php

namespace App\Repositories;

use App\Contracts\IUsersRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class UsersMariaDBRepository implements IUsersRepository{

    function save(User $usuario): User {
        $idGenerado = DB::table('usuario')->insertGetId([
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "pass_hasheada" => $usuario->passHasheada,
            "rol" => $usuario->rol,
            "modo_oscuro_activado" => $usuario->modoOscuroActivado,
        ]);
        $usuario->id = $idGenerado;
        return $usuario;
    }

    function update(User $usuario): void {
        DB::table("usuario")
        -> where("id", $usuario->id)
        ->update([
            "id" => $usuario->id,
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "pass_hasheada" => $usuario->passHasheada,
            "rol" => $usuario->rol,
            "modo_oscuro_activado" => $usuario->modoOscuroActivado,
        ]);
    }


    function getById($id): ?User {
        $usuarioEncontrado = DB::table('usuario')->find($id);

        if($usuarioEncontrado != null) {
            $usuarioEncontrado = $this->arrayAUsuario($usuarioEncontrado);
        }
        return $usuarioEncontrado;
    }




    function getByEmail(string $email): ?User {
        $usuarioEncontrado = DB::table('usuario')->where("email", $email)->first();

        if($usuarioEncontrado != null) {
            $usuarioEncontrado = $this->arrayAUsuario($usuarioEncontrado);
        }
        return $usuarioEncontrado;
    }


    function delete(int $idUsuario): bool {
        $numFilasBorradas = DB::table("usuario")->where("id", $idUsuario)->delete();

        return $numFilasBorradas != 0;
    }


    //TODO: codigo muy parecido
    function getByNombre(string $nombre): ?User {
        $usuarioEncontrado = DB::table('usuario')->where("nombre", $nombre)->first();

        if($usuarioEncontrado != null) {
            $usuarioEncontrado = $this->arrayAUsuario($usuarioEncontrado);
        }
        return $usuarioEncontrado;
    }




    private function arrayAUsuario(stdClass $usuario_db): User {
        return new User(
            $usuario_db->nombre,
            $usuario_db->email,
            $usuario_db->pass_hasheada,
            $usuario_db->rol,
            $usuario_db->modo_oscuro_activado,
            $usuario_db->id
        );
    }
}

?>