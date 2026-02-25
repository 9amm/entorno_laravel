<?php

use App\Contracts\IMensajesRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\TokenJWTValido;
use App\Http\Requests\RegisterApiRequest;
use App\Services\RegisterService;

Route::get("/users/me", function(Request $peticion) {
    $usuario = auth("api")->user();
    return response(["user" => $usuario]);
})->middleware(TokenJWTValido::class);



Route::get("/messages/{id}", function($id) {
    $repoMensajes = app()->make(IMensajesRepository::class);

    $mensajeEncontrado = $repoMensajes->getById($id);

    $respuesta = null;

    if($mensajeEncontrado == null) {
        $respuesta = response([
            "success" => false,
            "message" => "mensaje no existe",
        ], 404);
    } else {
        $respuesta = response([
            "message" => $mensajeEncontrado,
        ], 404);
    }

    return $respuesta;

})->whereNumber("id");

Route::post("/auth/register", function(RegisterApiRequest $peticion, RegisterService $registerService) {

    $nombre = $peticion->validated("nombre");
    $email = $peticion->validated("email");
    $passHasheada = $peticion->validated("pass");
    $rol = $peticion->validated("rol");

    $mensaje = $registerService->register(
        $nombre,
        $email,
        $passHasheada,
        $rol
    );

    $respuesta = null;
    
    if($mensaje) {
        $respuesta = response()->json([
            "message" => $mensaje
        ], 400);
    } else {
        $respuesta = response()->json([
            "message" => "ok"
        ], 201);
    }

    return $respuesta;
});



Route::post("auth/login", function(Request $request) {
    $nombreUsuario = $request->input("usuario");
    $passHasheada = $request->input("pass");

    $token = Auth::guard("api")->attempt([
        "usuario" => $nombreUsuario,
        "pass" => $passHasheada
    ]);

    return response()->json(["token" => $token]);

});

Route::get("/messages", function(Request $request){
    $repoMensajes = app()->make(IMensajesRepository::class);
    $listaMensajes = $repoMensajes -> getAll();
    $respuesta = null;

    if($listaMensajes == 0){
        $respuesta = response()->json([
            "success" => false,
            "error" => "No hay mensajes disponibles",
        ], 404);
    }else{
        $respuesta = response()->json([
            "success" => true,
            "messages" => $listaMensajes,
        ], 200);
    }

    return $respuesta;
});

//Route::post("messages", function(Request $request){
//});