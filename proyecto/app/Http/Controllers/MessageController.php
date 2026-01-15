<?php

namespace App\Http\Controllers;

use App\Contracts\IMensajesRepository;
use App\Models\EstadosMensaje;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IMensajesRepository $repositorioMensajes, AuthController $authController) {
        $usuarioLogeado = $authController->getUsuarioLogeado();
        $mensajesPublicados = $repositorioMensajes->getByEstado(EstadosMensaje::PUBLICADO);

        $respuesta = null;

        if(sizeof($mensajesPublicados) == 0) {
            $respuesta = view("error", [
                "usuarioLogeado" => $usuarioLogeado,
                "mensaje" => "Aún no hay ningún mensaje publicado."
            ]);
        } else {
            $respuesta = view("inicio", [
                "usuarioLogeado" => $usuarioLogeado,
                "mensajes" => $mensajesPublicados,
            ]);
        }

        return $respuesta;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mensaje $mensaje) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mensaje $mensaje) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mensaje $mensaje) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mensaje $mensaje) {
        //
    }
}
