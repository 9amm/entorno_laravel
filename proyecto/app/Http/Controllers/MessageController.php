<?php

namespace App\Http\Controllers;

use App\Contracts\IAsignaturasRepository;
use App\Contracts\IMensajesRepository;
use App\Models\EstadosMensaje;
use App\Models\Mensaje;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IMensajesRepository $repositorioMensajes) {
        $mensajesPublicados = $repositorioMensajes->getByEstado(EstadosMensaje::PUBLICADO);

        $respuesta = null;

        if(sizeof($mensajesPublicados) == 0) {
            $respuesta = view("error", [
                "mensaje" => "Aún no hay ningún mensaje publicado."
            ]);
        } else {
            $respuesta = view("inicio", [
                "mensajes" => $mensajesPublicados,
            ]);
        }

        return $respuesta;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(IAsignaturasRepository $repositorioAsignaturas): View {

        $asignaturas = $repositorioAsignaturas->getAll();

        return view("crear_mensaje", [
            "asignaturas" => $asignaturas
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $peticion, IMensajesRepository $repositorioMensajes, IAsignaturasRepository $repositorioAsignaturas, MessageService $messageService) {

        $usuarioLogeado = $peticion->user();

        $respuesta = null;

        $idAsignatura = $peticion->input("id_asignatura", "");
        $contenidoMensaje = $peticion->input("mensaje", "");

        if (empty($idAsignatura) || empty($contenidoMensaje)) {
            $respuesta = view("error", [ "mensaje" => "Todos los campos son obligatorios."]);

        } else if(!Mensaje::tieneLongitudValida($contenidoMensaje)) {
            $respuesta = view("error", [ "mensaje" => "Longitud del mensaje no valida."]);

        } else {
            $asignatura = $repositorioAsignaturas->getById($idAsignatura);

            if($asignatura != null) {
                $mensajeCreado = $messageService->guardar($contenidoMensaje,$usuarioLogeado, $asignatura, $repositorioMensajes);

                if($mensajeCreado->tieneEstado(EstadosMensaje::PELIGROSO)) {
                    $mensajeAlerta = "Hemos detectado que el mensaje contiene 
                        palabras vetadas, el mensaje queda pendiente de revisión
                        por parte de un moderador.";
                } else if($mensajeCreado->tieneEstado(EstadosMensaje::PENDIENTE)){
                    $mensajeAlerta = "Mensaje creado correctamente, queda pendiente de moderar.";
                }

                $respuesta = view("error", [
                    "mensaje" => $mensajeAlerta,
                ]);

            } else {
                $respuesta = view("error", [
                    "mensaje" => "Asignatura no encontrada.",
                ]);
            }
        }

        return $respuesta;
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
