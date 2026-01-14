@extends("layouts.base")

@section('contenido')
    <x-alerta>
        <x-slot name="icono">
            <x-icono-info></x-icono-info>
        </x-slot>

        {{$mensaje}}
    </x-alerta>
@endsection