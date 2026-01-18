@extends("layouts.base")

@php
    use App\Models\EstadosMensaje;
    use App\Model\Mensaje;
@endphp


@section('contenido')
    <x-sidebar nombre="{{$usuarioLogeado->nombre}}" rol="{{$usuarioLogeado->rol}}" es-profesor="{{$usuarioLogeado->esProfesor()}}"></x-sidebar>

    <x-contenido-principal titulo="Moderación">
        @foreach($mensajes as $mensaje)
            <x-mensaje 
                idMensaje="{{$mensaje->id}}"
                asignatura="{{$mensaje->getAsignatura()->nombre}}"
                fecha="{{$mensaje->getFechaCreacionFormateada()}}"
                usuario="{{$mensaje->getUsuario()->nombre}}"
                :haSidoModerado="false"
                esPeligroso="{{$mensaje->tieneEstado(EstadosMensaje::PELIGROSO)}}"
            >
                {{$mensaje->contenido}}
            </x-mensaje>
        @endforeach
    </x-contenido-principal>

@endsection
