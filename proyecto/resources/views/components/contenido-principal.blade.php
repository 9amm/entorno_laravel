@props([
    "titulo" => ""
])

<article>
    <x-topbar>{{$titulo}}</x-topbar>
    {{$slot}}
</article>