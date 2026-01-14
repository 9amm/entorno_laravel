@props([
    "idMensaje",
    "asignatura",
    "fecha",
    "usuario",
    "haSidoModerado" => false,
    "esPeligroso" => false
])

<section @class([
    "tarjeta",
    "tarjeta-peligro" => $esPeligroso,
])>

    <p class="mensaje-asignatura">{{ $asignatura }}</p>
    <p class="mensaje-fecha">{{ $fecha }}</p>
    <p class="mensaje-usuario">{{ $usuario }}</p>
    <p class="mensaje-contenido">{{ $slot }}</p> 

    @if(!$haSidoModerado)
        <button id_mensaje="{{ $idMensaje }}" class="boton" onclick="approveMessage(this)">Aprobar</button>
        <button id_mensaje="{{ $idMensaje }}" onclick="rejectMessage(this)">Rechazar</button>
    @endif
 
</section>