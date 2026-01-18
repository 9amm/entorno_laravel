@extends("layouts.base")


@section("contenido")
    <x-sidebar nombre="{{$usuarioLogeado->nombre}}" rol="{{$usuarioLogeado->rol}}" es-profesor="{{$usuarioLogeado->esProfesor()}}"></x-sidebar>

    <x-contenido-principal titulo="Asignaturas">
        @foreach($asignaturas as $asignatura)
            <x-tarjeta-asignatura idAsignatura="{{$asignatura->id}}">
                {{$asignatura->nombre}}
            </x-tarjeta-asignatura>
        @endforeach
    </x-contenido-principal>

@endsection