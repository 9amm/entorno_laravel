<?php
namespace App\Models;
use App\Repositories\MensajesJsonRepository;
use App\Models\Rol;



class User {

    public ?int $id;
	public string $nombre;
	public string $email;
	public string $passHasheada;
	public string $rol;
	public bool $modoOscuroActivado;

    function __construct(string $nombre, string $email, string $passHasheada, string $rol, bool $modoOscuroActivado = false, ?int $id = null) {
        $this->id = $id; //se le asigna valor al guardarlo en la bd json
        $this->nombre = $nombre;
        $this->email = $email;
        $this->passHasheada = $passHasheada;
        $this->rol = $rol;
        $this->modoOscuroActivado = $modoOscuroActivado;
    }

    function esAlumno(): bool {
        return $this->rol == Rol::ALUMNO;
    }

    function esProfesor(): bool {
        return $this->rol == Rol::PROFESOR;
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
      return new MensajesJsonRepository()->getByUser($this);
    }
}
?>