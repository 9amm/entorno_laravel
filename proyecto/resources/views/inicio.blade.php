@extends("layouts.base")


@section('contenido')

<x-sidebar nombre="paco" rol="profesor" esProfesor="false"></x-sidebar>

<x-contenido-principal titulo="aa">
    <h1>si</h1>
    <x-mensaje id-mensaje="22" usuario="paco" asignatura="bd" fecha="hoy">
        soy paco
    </x-mensaje>
</x-contenido-principal>

@endsection
