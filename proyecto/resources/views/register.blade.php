@extends("layouts.base")

@section("contenido")
    <script src="/recursos/js/hash.js" defer></script>

    <form class="contenedor-sesion" action="/register" method="post">

        <h1>Registrarse</h1>
        <label for="rol">Rol</label>
        <select name="rol" id="rol" required>
            <option value="alumno" selected>Alumno</option>
            <option value="profesor">Profesor</option>
        </select>

        <label for="nombre">Nombre</label>
        <input required type="text" name="nombre" id="nombre" pattern="^\w{2,30}$" minlength="2" maxlength="30" placeholder="Nombre" autocomplete="off">
        
        <label for="email">Email</label>
        <input required type="text" name="email" pattern="[a-zA-Z0-9_]{1,25}@[a-z0-9]{1,25}\.[a-z]{1,10}$" id="email" placeholder="Email" autocomplete="off">

        <label for="pass">Contraseña</label>
        <input id="pass" oninput="validarContasenas()" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])([a-zA-Z!@#$&*]{8,64})$" minlength="8" maxlength="64" required type="password" placeholder="Contraseña" autocomplete="off">
        <input id="confirmPass" oninput="validarContasenas()" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])([a-zA-Z!@#$&*]{8,64})$" minlength="8" maxlength="64" required type="password" placeholder="Repita contraseña" autocomplete="off">

        <input type="hidden" name="pass" id="hashed-pass">




        <p id="formulario-mensaje-error"></p>
        <input id="boton-registrarse" class="boton" type="submit" value="Registrarse">

        <script>
            const formulario = document.querySelector("form");
            const pass = document.getElementById("pass");
            const confirmPass = document.getElementById("confirmPass");
            const mensajeError = document.getElementById("formulario-mensaje-error");
            const botonRegistrarse = document.getElementById("boton-registrarse");

            function validarContasenas() {
                if(!cumpleFormato(pass.value) && !cumpleFormato(confirmPass.value)) {
                    mensajeError.textContent = "La contraseña tiene que tener mínimo 8 caráceteres, una mayúscula y un caracter especial: !@#$&*";

                } else if(pass.value != confirmPass.value){
                    let mensajeContrasenasNoCoinciden = "Las contraseñas no coinciden";
                    mensajeError.textContent = mensajeContrasenasNoCoinciden;
                    botonRegistrarse.setAttribute("disabled", "")
                    pass.setCustomValidity(mensajeContrasenasNoCoinciden);
                    confirmPass.setCustomValidity(mensajeContrasenasNoCoinciden);

                } else {
                    mensajeError.textContent = "";
                    botonRegistrarse.removeAttribute("disabled", "")
                    pass.setCustomValidity("");
                    confirmPass.setCustomValidity("");
                }
            }

            function cumpleFormato(contrasena) {
                return /^(?=.*[A-Z])(?=.*[!@#$&*])([a-zA-Z!@#$&*]{8,64})$/.test(contrasena);
            }

        </script>


        <p>¿Ya tienes cuenta? <a href="/login">Iniciar Sesión</a></p>

    </form>
@endsection