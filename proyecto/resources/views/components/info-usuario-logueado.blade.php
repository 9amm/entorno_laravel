@props([
    "nombre",
    "rol",
])

<div class="contenedor-cuenta">
    <div class="usuario">
        <p>{{ $nombre }}</p>
        <p>{{ $rol }}</p>
    </div>

    <button id="boton-logout" title="Cerrar sesión" data-url="{{route('logout')}}" onclick="logout(this)"></button>
</div>
