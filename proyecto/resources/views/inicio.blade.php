@extends("layouts.base")


@section('contenido')

<x-sidebar nombre="{{$usuarioLogeado->nombre}}" rol="{{$usuarioLogeado->rol}}" es-profesor="{{$usuarioLogeado->esProfesor()}}"></x-sidebar>

<x-contenido-principal titulo="Inicio">

    @foreach($mensajes as $mensaje)
        <x-mensaje 
            idMensaje="{{$mensaje->id}}"
            asignatura="{{$mensaje->getAsignatura()}}"
            fecha="{{$mensaje->getFechaCreacionFormateada()}}"
            usuario="{{$mensaje->getUsuario()->nombre}}"
            :haSidoModerado="true"
        >
            {{$mensaje->contenido}}
        </x-mensaje>
    @endforeach


</x-contenido-principal>

@endsection
