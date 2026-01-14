<?php

use App\Http\Controllers\LoginController;
use App\Http\Middleware\Autenticar;
use App\Models\Asignatura;
use Illuminate\Support\Facades\Route;
use App\Models\Mensaje;
use App\Models\EstadosMensaje;
use App\Repositories\MensajesJsonRepository;
use App\Repositories\UsersJsonRepository;

Route::get('/', function () {
    print_r("a");
})
    ->name("inicio")
    ->middleware(Autenticar::class);

Route::get('/login', [LoginController::class, "show"])
    ->name("login_formulario");

Route::post('/login', [LoginController::class, "login"])
    ->name("login_post");

//cuando la ruta no se encuentre mostramos pagina de 404
Route::fallback(fn() => view('no_encontrado'));