@extends("layouts.base")


@section('contenido')

<x-sidebar nombre="{{$nombreUsuario}}" rol="{{$rol}}" es-profesor="{{$esProfesor}}"></x-sidebar>

<x-contenido-principal titulo="Inicio">

    @foreach($mensajes as $mensaje)
    <x-mensaje 
        idMensaje="{{$mensaje->id}}"
        {{-- asignatura="{{$mensaje->getAsignatura()->nombre}}" --}}
        asignatura="hola"
        fecha="{{$mensaje->getFechaCreacionFormateada()}}"
        usuario="{{$mensaje->getUsuario()->nombre}}"
        :haSidoModerado="true"
    >
        {{$mensaje->contenido}}
    </x-mensaje>
    @endforeach


</x-contenido-principal>

@endsection
