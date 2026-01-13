@extends("layouts.base")


@section('contenido')

<x-sidebar nombre="{{$nombreUsuario}}" rol="{{$rol}}" es-profesor="{{$esProfesor}}"></x-sidebar>

<x-contenido-principal titulo="Inicio">

    @foreach($mensajes as $mensaje)
    <x-mensaje 
        idMensaje="{{$mensaje->id}}"
        asignatura="nombreasignatura"
        fecha="2348/87234/342"
        usuario="paco"
        :haSidoModerado="true"
    >
        {{$mensaje->contenido}}
    </x-mensaje>
    @endforeach


</x-contenido-principal>

@endsection
