@extends("layouts.base")


@section('contenido')

<x-sidebar nombre="{{$nombreUsuario}}" rol="{{$rol}}" es-profesor="{{$esProfesor}}"></x-sidebar>

<x-contenido-principal titulo="Inicio">

    @foreach($mensajes as $mensaje)
        <x-mensaje 
            idMensaje="{{$idMensaje}}"
            asignatura="{{$nombreAsignatura}}"
            fecha="{{$fecha}}"
            usuario="{{$nombreUsuario}}"
            :haSidoModerado="true"
        >
            {{$contenidoMensaje}}
        </x-mensaje>
    @endforeach


</x-contenido-principal>

@endsection
