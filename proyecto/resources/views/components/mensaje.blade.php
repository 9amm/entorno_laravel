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
        <button class="boton" onclick="approveMessage({{$idMensaje}})">Aprobar</button>
        <button onclick="rejectMessage({{$idMensaje}})">Rechazar</button>
    </div>
    @endif
 
</section>