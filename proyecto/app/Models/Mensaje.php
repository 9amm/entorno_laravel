<?php
	
namespace App\Models;
use App\Utils\Utils;

class EstadosMensaje {
    public const string PUBLICADO = "publicado";
    public const string PENDIENTE = "pendiente";
    public const string RECHAZADO = "rechazado";
    public const string PELIGROSO = "peligroso";
}


class Mensaje {
    const LONGITUD_MINIMA = 1;
    const LONGITUD_MAXIMA = 280;

	public ?int $id;
	public string $contenido;
	public int $idAsignatura;
	public int $idUsuario;
	public string $estadoMensaje;
	public int $timestampCreacion;



    function __construct (string $contenido, int $idAsignatura, int $idUsuario, string $estadoMensaje, int $timestampCreacion, ?int $id = null) {
        $this->id = $id;
        $this->contenido = $contenido;
        $this->idAsignatura = $idAsignatura;
        $this->idUsuario = $idUsuario;
        $this->estadoMensaje = $estadoMensaje;
        $this->timestampCreacion = $timestampCreacion;
    }

    static function tieneLongitudValida($contenidoMensaje) {
        $longitud = strlen($contenidoMensaje);
        return $longitud >= self::LONGITUD_MINIMA && $longitud <= self::LONGITUD_MAXIMA;
    }

// filtro de palabras prohibidas
      private static array $palabrasVetadas = [
        '<script',
        'onerror=',
        'drop table',
        'idiota',
        'tonto',
        'maldito',
        'perro sanche'
    ];

     static function contienePalabrasVetadas(string $contenido): bool {
        $contenidoMin = strtolower($contenido);
        foreach (self::$palabrasVetadas as $prohibida) {
            if (str_contains($contenidoMin, strtolower($prohibida))) {
                return true;
            }
        }
        return false;
    }


    /**
     * @return bool si el mensaje esta en el estado que se pasa como parametro
     * @see EstadosMensaje
     */
    function tieneEstado(string $estado):bool {
        return $this->estadoMensaje == $estado;
    }

    /**
     * @return bool devuelve si el estado del mensaje esta en la lista
     * de estados que se pasa como parametro
     */
    function tieneAlgunoDeLosEstados(array $estados):bool {
        return in_array($this->estadoMensaje, $estados);
    }

    function getFechaCreacionFormateada() : string {
        return Utils::getFechaFormateadaDesdeTimestamp($this->timestampCreacion);
    }

}

?>