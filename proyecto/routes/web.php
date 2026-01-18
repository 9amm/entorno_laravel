<?php

use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\Error404NoEncontrado;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModeracionController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\Autenticar;
use App\Http\Middleware\NecesitaRol;
use App\Models\Rol;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [MessageController::class, "index"])
    ->name("inicio")
    ->middleware(Autenticar::class);

Route::get('/subjects', [AsignaturasController::class, "index"])
    ->name("asignaturas_listado")
    ->middleware(Autenticar::class);

Route::get('/subjects/{id}', [AsignaturasController::class, "show"])
    ->name("asignaturas_detalle")
    ->middleware(Autenticar::class);

Route::get('/messages/new', [MessageController::class, "create"])
    ->name("mensaje_formulario_crear")
    ->middleware(Autenticar::class);

Route::post('/messages', [MessageController::class, "store"])
    ->name("mensaje_formulario_guardar")
    ->middleware(Autenticar::class);


Route::get('/moderation', [ModeracionController::class, "index"])
    ->name("mensaje_pendientes_moderar")
    ->middleware(Autenticar::class)
    ->middleware(NecesitaRol::class . ":" .Rol::PROFESOR);


Route::post('/moderation/{id}/{accion}', [ModeracionController::class, "moderar"])
    ->name("mensaje_moderar")
    ->middleware(Autenticar::class)
    ->middleware(NecesitaRol::class . ":" .Rol::PROFESOR);



Route::get('/login', [LoginController::class, "show"])
    ->name("login_formulario");

Route::get('/register', [RegisterController::class, "show"])
    ->name("register_formulario");

Route::post('/register', [RegisterController::class, "register"])
    ->name("register_post");

Route::post('/login', [LoginController::class, "login"])
    ->name("login_post");


//rutas mensajes
/*
Route::get('/messages', [MessagesController::class, "messages"])
    ->name("messages_post");

Route::post('/messages/new', [MessagesController::class, "messages"])
    ->name("messages_post");

//rutas moderacion
Route::get('/moderation/', [ModerationController::class, "moderation"])
    ->name("moderation");

Route::post('/moderation/{id}/approve', [ModerationController::class, "moderation"])
    ->name("moderation_approve");

Route::post('/moderation/{id}/reject', [ModerationController::class, "moderation"])
    ->name("moderation_reject");
 */


//cuando la ruta no se encuentre mostramos pagina de 404
Route::fallback(fn() => abort(404));