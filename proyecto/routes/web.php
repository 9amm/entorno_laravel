<?php

use App\Models\Asignatura;
use Illuminate\Support\Facades\Route;
use App\Models\Mensaje;
use App\Models\EstadosMensaje;
use App\Repositories\MensajesJsonRepository;

Route::get('/', function () {

    //$repo = new MensajesJsonRepository();
    //$repo->save(new Mensaje("pruebaaa", 2, 1, EstadosMensaje::PELIGROSO, 1, 1));
    //$mensajes = $repo->getAll();

    $datos = [
        "nombreUsuario" => "paco",
        "rol" => "hola",
        "esProfesor" => "true",
        "asignaturas" => [
            new Asignatura("bd", 1),
            new Asignatura("sistemas", 2),
            new Asignatura("desarrollo de interfaces", 3)
        ]
    ];

    return view("asignaturas", $datos);
});
