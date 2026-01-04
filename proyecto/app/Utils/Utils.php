<?php

namespace App\Utils;

class Utils {
    /**
     * Devuelve un string con fecha (dia, mes anio) en formato 01-01-2025 a
     * partir de un timestamp que se pase como parametro
     */
    static function getFechaFormateadaDesdeTimestamp(int $timestamp) : string {
        return date("d/m/Y",$timestamp);
    }


    static function contrasenaHasheadaCumpleFormato(string $contrasena): bool {
        //el hash que se envia desde el frontend es sha256 y estos hashes tienen siempre 64 caracteres
        return strlen($contrasena) == 64;
    }


    static function emailCumpleFormato(string $email): bool {
        return preg_match("/[a-zA-Z0-9_]{1,25}@[a-z0-9]{1,25}\.[a-z]{1,10}$/", $email);
    }

    static function nombreCumpleFormato(string $nombre): bool {
        return preg_match("/^\w{2,30}$/", $nombre);
    }
}

?>