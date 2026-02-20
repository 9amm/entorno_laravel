<?php

namespace App\Http\Controllers;

use App\Contracts\IAsignaturasRepository;
use App\Contracts\IMensajesRepository;
use App\Http\Requests\CrearMensajeRequest;
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
    public function store(CrearMensajeRequest $peticion, IMensajesRepository $repositorioMensajes, IAsignaturasRepository $repositorioAsignaturas, MessageService $messageService) {
        $datosValidados = $peticion->validated();

        $idAsignatura = $datosValidados["id_asignatura"];
        $contenidoMensaje = $datosValidados["mensaje"];


        $asignatura = $repositorioAsignaturas->getById($idAsignatura);

        if($asignatura != null) {
            $usuarioLogeado = $peticion->user();
            $mensajeCreado = $messageService->guardar($contenidoMensaje, $usuarioLogeado, $asignatura, $repositorioMensajes);

            if ($mensajeCreado->tieneEstado(EstadosMensaje::PELIGROSO)) {
                $textoMostrar = "Hemos detectado que el mensaje contiene 
                            palabras vetadas, el mensaje queda pendiente de revisión
                            por parte de un moderador.";

            } else if($mensajeCreado->tieneEstado(EstadosMensaje::PENDIENTE)) {
                $textoMostrar = "Mensaje creado correctamente, queda pendiente de moderar.";
            }
        } else {
            $textoMostrar = "No se ha podido encontrar la asignatura.";
        }

        return view("error", [
            "mensaje" => $textoMostrar
        ]);
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
