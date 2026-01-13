<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Mensaje;
use App\Models\EstadosMensaje;

Route::get('/', function () {

    $usuarioPrueba = new User("a", "b", "c", "d");
    $mensajes = [
        new Mensaje("hola que tal", 2, 2, EstadosMensaje::PUBLICADO, 1, 2),
        new Mensaje("pruebaaa", 2, 2, EstadosMensaje::PUBLICADO, 1, 2),
        // (string $contenido, int $idAsignatura, int $idUsuario, string $estadoMensaje, int $timestampCreacion, ?int $id )
    ];
    $datos = [
        "nombreUsuario" => "paco",
        "rol" => "si",
        "esProfesor" => false,
        "mensajes" => $mensajes,
    ];
    return view('inicio', $datos);
});
