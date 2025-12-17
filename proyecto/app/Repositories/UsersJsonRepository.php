<?php


class UsersJsonRepository implements IUsersRepository{
    private JsonDb $archivoUsuarios;

    function __construct() {
        $this->archivoUsuarios = new JsonDb(JsonDb::USUARIOS);
        $contenidoArchivo = $this->archivoUsuarios->leer();


    }



    function save(User $usuario): void {
        $contenidoArchivo = $this->archivoUsuarios->leer();
        $usuario->id = ++$contenidoArchivo["ultimoId"];

        $contenidoArchivo["items"][$usuario->id] = $usuario;

        $this->archivoUsuarios->escribir((array) $contenidoArchivo);
    }

    function update(User $usuario): void {
        $contenidoArchivo = $this->archivoUsuarios->leer();
        $contenidoArchivo["items"][$usuario->id] = $usuario;
        $this->archivoUsuarios->escribir((array) $contenidoArchivo);
    }


    function getById($id): ?User {
        $contenidoArchivo = $this->archivoUsuarios->leer();
        $usuarioEncontrado = $contenidoArchivo["items"][$id] ?? null;

        if($usuarioEncontrado == null) {
            return null;
        }

        return $this->arrayAUsuario($usuarioEncontrado);
    }




    function getByEmail(string $email): ?User {
        $contenidoArchivo = $this->archivoUsuarios->leer();
        $usuarios = $contenidoArchivo["items"];

        foreach($usuarios as $usuario) {
            if($usuario["email"] == $email) {
                return $this->arrayAUsuario($usuario);
            }
        }
        return null;
    }




    //TODO: codigo muy parecido
    function getByNombre(string $nombre): ?User {
        $contenidoArchivo = $this->archivoUsuarios->leer();
        $usuarios = $contenidoArchivo["items"];

        foreach($usuarios as $usuario) {
            if($usuario["nombre"] == $nombre) {
                return $this->arrayAUsuario($usuario);
            }
        }
        return null;
    }




    private function arrayAUsuario(array $usuario): User {
        return new User(
            $usuario["nombre"],
            $usuario["email"],
            $usuario["passHasheada"],
            $usuario["rol"],
            $usuario["modoOscuroActivado"],
            $usuario["id"]
        );
    }
}

?>