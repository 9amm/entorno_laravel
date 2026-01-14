<?php

use Illuminate\Support\Facades\Route;
use App\Models\Mensaje;
use App\Models\EstadosMensaje;
use App\Repositories\MensajesJsonRepository;

Route::get('/', function () {

    $repo = new MensajesJsonRepository();
    $repo->save(new Mensaje("pruebaaa", 2, 1, EstadosMensaje::PELIGROSO, 1, 1));
    $mensajes = $repo->getAll();

    $datos = [
        "nombreUsuario" => "paco",
        "rol" => "hola",
        "esProfesor" => "true",
        "asignaturas" => $mensajes,
    ];

    //print_r(EstadosMensaje::PELIGROSO);
    return view('moderacion', $datos);
});
