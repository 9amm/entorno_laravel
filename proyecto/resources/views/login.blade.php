@extends("layouts.base")

@section("contenido")
    <script src="/recursos/js/hash.js" defer></script>

    <form class="contenedor-sesion" method="post" action="/login">
        @csrf
        <h1>Iniciar sesión</h1>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario" autocomplete="off" required>

        <label for="pass">Contraseña</label>
        <input type="password" id="pass" placeholder="Contraseña" required>
        <input type="hidden" name="pass" id="hashed-pass">

        <input class="boton" type="submit" value="Iniciar Sesión">
        
        <p>¿No tienes cuenta? <a href="{{route('register_formulario')}}">Registrarse</a></p>
    </form>

@endsection