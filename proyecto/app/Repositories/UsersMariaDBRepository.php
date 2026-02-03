<?php

namespace App\Repositories;

use App\Contracts\IUsersRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class UsersMariaDBRepository implements IUsersRepository{

    function save(User $usuario): void {
        DB::table('usuarios')->insert([
            "id" => $usuario->id,
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "pass_hasheada" => $usuario->passHasheada,
            "rol" => $usuario->rol,
            "modo_oscuro_activado" => $usuario->modoOscuroActivado,
        ]);
    }

    function update(User $usuario): void {
        DB::table("usuarios")
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
        $usuarioEncontrado = DB::table('usuario')->find($email);

        if($usuarioEncontrado != null) {
            $usuarioEncontrado = $this->arrayAUsuario($usuarioEncontrado);
        }
        return $usuarioEncontrado;
    }




    //TODO: codigo muy parecido
    function getByNombre(string $nombre): ?User {
        $usuarioEncontrado = DB::table('usuario')->find($nombre);

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