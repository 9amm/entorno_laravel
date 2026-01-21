<aside>
    <h1>Red social</h1>
    <nav>
        <ul>
            <li><a id="inicio" href="{{ route("inicio") }}">Inicio</a></li>
            @if(Auth::user()->esProfesor())
                <li><a id="moderacion" href="{{ route("mensaje_pendientes_moderar") }}">Moderación</a></li>
            @endif

            <li><a id="asignaturas" href="{{ route("asignaturas_listado") }}">Asignaturas</a></li>
            <li><a id="crear-mensaje" class="boton" href=" {{route("mensaje_formulario_crear")}}">Crear mensaje</a></li>
        </ul>
    </nav>


    <x-info-usuario-logueado nombre="{{ Auth::user()->nombre }}" rol="{{ Auth::user()->rol }}"></x-info-usuario-logueado>

</aside>