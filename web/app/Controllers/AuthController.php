<?php


class AuthController {

    static function estaLogueado() {
        $id = $_SESSION["idUsuario"] ?? "";
        return new Users()->getById($id) != null;
    }

    static function redirigir(string $url) {
        header("Location: $url");
        exit();
    }

    static function setUsuarioLogeado(User $usuario) {
        $_SESSION["idUsuario"] = $usuario->id;
    }

    static function logout() {
        $_SESSION["idUsuario"] = "";
    }

    static function getUsuarioLogeado(): ?User {
        $idUsuario = $_SESSION["idUsuario"] ?? "";
        return new Users()->getById($idUsuario);
    }

    /**
     * Comprueba si el usuario esta logueado, si no esta logueado lo redirije a la pagina de inicio de sesion
     * puede llamarse antes de cargar una vista si solo queremos que puedan acceder usuarios logueados 
     */
    static function loginObligatorio() {
        if(!self::estaLogueado()) {
            //el usuario esta intentando acceder a una ruta de la web y no tiene sesion iniciada
            //vamos a guardar la ruta a la que esta intentando acceder para que
            //cuando inicie sesion poder redirigirlo
            $_SESSION["loginRedirigir"] = $_SERVER["REQUEST_URI"];
            self::redirigir("/login");
        }
    }


}

?>