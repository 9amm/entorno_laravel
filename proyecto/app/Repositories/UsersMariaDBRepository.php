<?php

namespace App\Repositories;

use App\Contracts\IUsersRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class UsersMariaDBRepository implements IUsersRepository{

    function save(User $usuario): void {
        $usuario = [
            "id" => $usuario->id,
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "pass_hasheada" => $usuario->passHasheada,
            "rol" => $usuario->rol,
            "modo_oscuro_activado" => $usuario->modoOscuroActivado,
        ];
        DB::insert("insert into `usuario` (`id`, `nombre`, `email`, `pass_hasheada`, `rol`, `modo_oscuro_activado`) values (:id, :nombre, :email, :pass_hasheada, :rol, :modo_oscuro_activado);", $usuario);
    }

    function update(User $usuario): void {
        $usuario = [
            "id" => $usuario->id,
            "nombre" => $usuario->nombre,
            "email" => $usuario->email,
            "pass_hasheada" => $usuario->passHasheada,
            "rol" => $usuario->rol,
            "modo_oscuro_activado" => $usuario->modoOscuroActivado,
        ];
        DB::update('update usuario set nombre = :nombre, email = :email, pass_hasheada = :pass_hasheada, rol = :rol, modo_oscuro_activado = :modo_oscuro_activado where id = :id', $usuario);
    }


    function getById($id): ?User {
        $usuarioEncontrado = DB::select("select * from usuario where id = ?", [$id])[0] ?? null;

        if($usuarioEncontrado == null) {
            return null;
        }

        return $this->arrayAUsuario($usuarioEncontrado);
    }




    function getByEmail(string $email): ?User {
        $usuarioEncontrado = DB::select("select * from usuario where email = ?", [$email])[0] ?? null;

        if($usuarioEncontrado == null) {
            return null;
        }

        return $this->arrayAUsuario($usuarioEncontrado);
    }




    //TODO: codigo muy parecido
    function getByNombre(string $nombre): ?User {
        $usuarioEncontrado = DB::select("select * from usuario where nombre = ?", [$nombre])[0] ?? null;

        if($usuarioEncontrado == null) {
            return null;
        }

        return $this->arrayAUsuario($usuarioEncontrado);
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