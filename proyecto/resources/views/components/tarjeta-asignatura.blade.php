@props([
    "idAsignatura"
])

<a class="tarjeta-asignatura tarjeta tarjeta-hover" href="{{ route("asignaturas_detalle", ["asignatura" => $idAsignatura]) }}">
    {{$slot}}
</a>