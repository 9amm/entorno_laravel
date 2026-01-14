<?php

namespace App\Http\Controllers;

use App\Contracts\IUsersRepository;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller {

    public IUsersRepository $userRepository;

    public function __construct(IUsersRepository $userRepository) {
        $this->userRepository = $userRepository;
    }


    function getUsuarioLogeado(): ?User {
        $idUsuario = $_SESSION["idUsuario"] ?? "";
        return $this->userRepository->getById($idUsuario);
    }

    function usuarioEstaLogueado(): bool {
        return self::getUsuarioLogeado() != null;
    }

    function setUsuarioLogeado(User $usuario): void {
        $_SESSION["idUsuario"] = $usuario->id;
    }


    function logout(): void{
        $_SESSION["idUsuario"] = "";
    }

    /**
     * Crea el encabezado location para redirigir al usuario a una url
     * que se pase como parametro.
     */
    function redirigir(string $url): void {
        header("Location: $url");
    }


    /**
     * Crea un encabezado que redirije a una url que se pase como parametro
     * y guarda la url actual. 
     * Esto lo usamos cuando un usuario entra a un enlace
     * que necesita login como por ejemplo /subjects, como no esta logueado
     * lo redirigimos a la pagina de login y desde la pagina de login a la 
     * página que queria entrar desde un inicio osea /subjects
     * @see getOrigenRedireccion()
     */
    function redirigirGuardandoOrigen(string $url):void {
        $_SESSION["origenRedireccion"] = $_SERVER["REQUEST_URI"];
        self::redirigir($url);
    }

    function redirigirALogin():void {
        self::redirigirGuardandoOrigen("/login");
    }

    /**
     * Devuelve la ruta desde la que se ha redirigido
     * Si desde /subjects se redirije a /moderation, desde /moderation
     * podemos saber que antes el usuario estaba /subjets
     */
    function getOrigenRedireccion(): ?string {
        return $_SESSION["origenRedireccion"] ?? null;
    }


}

?>