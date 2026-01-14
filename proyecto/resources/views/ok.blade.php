@extends("layouts.base")

@section("contenido")
    <x-sidebar nombre="{{$nombreUsuario}}" rol="{{$rol}}" es-profesor="{{$esProfesor}}"></x-sidebar>
    <x-contenido-principal>
        <x-alerta>
            <x-slot name="icono">
                <x-icono-ok></x-icono-ok>
            </x-slot>

            {{$mensaje}}
        </x-alerta>
    </x-contenido-principal>
@endsection