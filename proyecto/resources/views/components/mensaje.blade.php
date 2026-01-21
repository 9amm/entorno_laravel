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
    <div>
        <button class="boton"  data-url="{{route('mensaje_moderar', ["mensaje" => $idMensaje, "accion" => "approve"])}}" onclick="approveMessage(this)">Aprobar</button>
        <button data-url="{{route('mensaje_moderar', ["mensaje" => $idMensaje, "accion" => "reject"])}}" onclick="rejectMessage(this)">Rechazar</button>
    </div>
    @endif
 
</section>