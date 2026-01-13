
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("titulo", "Red social")</title>
    <link rel="stylesheet" href="/recursos/estilos.css">
    <script src="/recursos/js/modo_oscuro.js"></script>
</head>

<body>
    <main>
        @yield("contenido")
    </main>
</body>

<script>cargarTema()</script>
</html>
