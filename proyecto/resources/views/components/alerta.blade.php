@props([
    "icono"
])

<div class="mensaje-info">

    {{$icono}}

    <p class="texto-mensaje-info">{{$slot}}</p>
    <button class="boton" onclick="window.history.back()">Volver</button>
</div>