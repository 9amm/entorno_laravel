@extends("layouts.base")


@section('contenido')


    <x-mensaje id-mensaje="22" usuario="paco" asignatura="bd" fecha="hoy">
        esto es contenido
    </x-mensaje>

    <x-topbar>
        Inicio
    </x-topbar>


@endsection
