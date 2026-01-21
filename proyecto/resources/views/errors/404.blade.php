@extends("layouts.base")

@section('contenido')
    <main>
        <div id="mensaje-error">
            <h1>Error 404</h1>
            <p>Recurso no encontrado</p>
            <button onclick="window.location.href = '{{route('inicio')}}'">Volver a la página principal</button>
        </div>
    </main>
@endsection