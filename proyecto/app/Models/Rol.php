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

    public static function existe(string $rol) {
        //TODO: fragil
        return $rol == self::ALUMNO || $rol  == self::PROFESOR;
    }
}