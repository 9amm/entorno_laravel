<?php

namespace App\Models;

class Rol {
    /**
     * aqui era mejor usar un enum pero json_decode no los soporta ademas en 
     * php los enums se guardan como objetos y esto solo complica las cosas cuando
     * vayamos a leer desde el archivo json
    */
    public const string ALUMNO = "alumno";
    public const string PROFESOR = "profesor";
}


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