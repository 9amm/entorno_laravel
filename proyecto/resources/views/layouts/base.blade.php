
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("titulo", "Red social")</title>
    <link rel="stylesheet" href="/recursos/estilos.css">
    <script src="/recursos/js/principal.js"></script>
    <meta csrf-token="{{csrf_token()}}">
</head>

<body>
    <main>
        @yield("contenido")
    </main>
</body>

<script>cargarTema()</script>
</html>
