@props([
    "idAsignatura"
])

<a class="tarjeta-asignatura tarjeta tarjeta-hover" href="/subjects/{{ $idAsignatura }}>">
    {{$slot}}
</a>