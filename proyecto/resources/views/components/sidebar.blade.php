@props([
    "nombre",
    "rol",
    "esProfesor",
])

<aside>
    <h1>Red social</h1>
    <nav>
        <ul>
            <li><a id="inicio" href="/">Inicio</a></li>
            @if($esProfesor)
                <li><a id="moderacion" href="/moderation">Moderación</a></li>
            @endif

            <li><a id="asignaturas" href="/subjects">Asignaturas</a></li>
            <li><a id="crear-mensaje" class="boton" href="/messages/new">Crear mensaje</a></li>
        </ul>
    </nav>


    <x-info-usuario-logueado nombre="{{ $nombre }}" rol="{{ $rol }}"></x-info-usuario-logueado>

</aside>