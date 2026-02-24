<?php
namespace App\Models;

use App\Contracts\IMensajesRepository;
use App\Models\Rol;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Contracts\JWTSubject as JWT;

class User implements Authenticatable, JWT{

    public ?int $id;
	public string $nombre;
	public string $email;
	public string $passHasheada;
	public string $rol;
	public bool $modoOscuroActivado;
    public IMensajesRepository $repositorioMensajes;

    function __construct(string $nombre, string $email, string $passHasheada, string $rol, bool $modoOscuroActivado = false, ?int $id = null) {
        $this->id = $id; //se le asigna valor al guardarlo en la bd json
        $this->nombre = $nombre;
        $this->email = $email;
        $this->passHasheada = $passHasheada;
        $this->rol = $rol;
        $this->modoOscuroActivado = $modoOscuroActivado;
        $this->repositorioMensajes = App::make(IMensajesRepository::class);
    }

    function tieneRol(string $rol) {
        return $this->rol == $rol;
    }

    function esAlumno(): bool {
        return $this->tieneRol(Rol::ALUMNO);
    }

    function esProfesor(): bool {
        return $this->tieneRol(Rol::PROFESOR);
    }

    function prefiereModoOscuro(): bool {
        return $this->modoOscuroActivado;
    }

    function setModoOscuroActivado($modoOscuroActivado) {
        $this->modoOscuroActivado = $modoOscuroActivado;
    }

    function getModoOscuroActivado() {
        return $this->modoOscuroActivado;
    }


    /**
     * Devuelve todos los mensajes que ha publicado un usuario
     */
    function getMensajes(): array {
        return $this->repositorioMensajes->getByUser($this);
    }



    //AUTHENTICATABLE
    public function getAuthIdentifierName() {
        return "id";
    }

    public function getAuthIdentifier() {
        return $this->id;
    }

    public function getAuthPassword() {
        return $this->passHasheada;
    }

    public function getAuthPasswordName() {
        return "pass_hasheada";
    }

    public function getRememberToken() {
    }

    public function setRememberToken($value) {
    }

    public function getRememberTokenName() {
    }


    //JWT
    public function getJWTIdentifier() {
        return $this->id;
    }

    public function getJWTCustomClaims() {
        return [
            "rol" => $this->rol
        ];
    }






}
?>