<?php

use App\Http\Controllers\LoginController;
use App\Http\Middleware\Autenticar;
use App\Models\Asignatura;
use Illuminate\Support\Facades\Route;
use App\Models\Mensaje;
use App\Models\EstadosMensaje;
use App\Repositories\MensajesJsonRepository;

Route::get('/', function () {

})
    ->name("inicio")
    ->middleware(Autenticar::class);

Route::get('/login', [LoginController::class, "show"])
    ->name("login");

//cuando la ruta no se encuentre mostramos pagina de 404
Route::fallback(fn() => view('no_encontrado'));