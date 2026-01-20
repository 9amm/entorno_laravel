<?php

namespace App\Http\Controllers;

use App\Contracts\IMensajesRepository;
use App\Models\EstadosMensaje;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class ModeracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IMensajesRepository $repositorioMensajes) {
        $respuesta = null;
        $mensajesPendientesModerar = $repositorioMensajes->getByEstados([EstadosMensaje::PENDIENTE, EstadosMensaje::PELIGROSO]);

        if(sizeof($mensajesPendientesModerar) == 0) {
            $respuesta = view("error", [
                "mensaje" => "Aún no hay ningún mensaje para moderar.",
            ]);
        } else {
            $respuesta = view("moderacion", [
                "mensajes" => $mensajesPendientesModerar
            ]);
        }

        return $respuesta;
    }

    public function moderar(IMensajesRepository $repositorioMensajes, Mensaje $mensaje, string $accion) {

        if ($mensaje == null) {
            echo ("mensaje no encontrado");
        } else if (!$mensaje->tieneAlgunoDeLosEstados([EstadosMensaje::PENDIENTE, EstadosMensaje::PELIGROSO])) {
            echo ("el mensaje no esta pendiente de moderar");
        } else {

            if ($accion == "approve") {
                $mensaje->estadoMensaje = EstadosMensaje::PUBLICADO;
            } else if ($accion == "reject") {
                $mensaje->estadoMensaje = EstadosMensaje::RECHAZADO;
            }

            $repositorioMensajes->update($mensaje);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
