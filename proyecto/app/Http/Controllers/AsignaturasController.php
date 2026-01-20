<?php

namespace App\Http\Controllers;

use App\Contracts\IAsignaturasRepository;
use App\Models\Asignatura;
use App\Models\EstadosMensaje;
use Illuminate\Http\Request;

class AsignaturasController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(IAsignaturasRepository $repositorioAsignaturas, AuthController $authController, Request $peticion) {
        $asinaturas = $repositorioAsignaturas->getAll();
        $usuarioLogeado = $peticion->user();

        $respuesta = null;

        //si no hay asignaturas
        if(sizeof($asinaturas) == 0) {
            //cargarLayout($usuario, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ninguna asignatura."]);
            $respuesta = view("error", [
                "mensaje" => "Aún no hay ninguna asignatura.",
                "usuarioLogeado" => $usuarioLogeado
            ]);
        } else {
            $respuesta = view("asignaturas", [
                "asignaturas" => $asinaturas,
                "usuarioLogeado" => $usuarioLogeado
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
    public function show(Request $peticion, Asignatura $asignatura) {
        //buscamos en la bd la asignatura con el id que se pase como parametro
        $usuarioLogeado = $peticion->user();

        //si no encontramos ninguna asignatura
        if($asignatura != null) {
            //obtenemos todos los mensajes publicados de esa asignatura
            $mensajes = $asignatura->getMensajesPorEstado(EstadosMensaje::PUBLICADO);
            //guardamos cuantos mensajes son
            $numMensajes = sizeof($mensajes);

            $variablesVista = [
                "asignatura" => $asignatura,
                "mensajes" => $mensajes,
                "numMensajes" => $numMensajes,
                "usuarioLogeado" => $usuarioLogeado,
            ];

            $respuesta = view("detalle_asignatura", $variablesVista);

        } else {
            $respuesta = view("error", [
                "mensaje" => "Asignatura no encontrada",
                "usuarioLogeado" => $usuarioLogeado,
            ]);
        }

        return $respuesta;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignatura $asignatura) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura) {
        //
    }
}
