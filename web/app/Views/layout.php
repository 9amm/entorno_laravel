<aside>
    <h1>Red social</h1>
    <nav>
        <ul>
            <li><a id="inicio" href="/">Inicio</a></li>
            <?if($usuarioLogeado->esProfesor()):?>
            <li><a id="moderacion" href="/moderation">Moderación</a></li>
            <?endif;?>

            <li><a id="asignaturas" href="/subjects">Asignaturas</a></li>
            <li><a id="crear-mensaje" class="boton" href="/messages/new">Crear mensaje</a></li>
        </ul>
    </nav>


    <div class="contenedor-cuenta">
        <div class="usuario">
            <p><?=htmlspecialchars($usuarioLogeado->nombre)?></p>
            <p><?=htmlspecialchars($usuarioLogeado->rol)?></p>
        </div>

        <script>
            async function enviarPeticionLogout() {
                await fetch("/logout", {method: "POST"});
                location.reload();
            }

            async function logout() {
                if(confirm("¿Cerrar sesión?")) {
                    await enviarPeticionLogout();
                }
            }
        </script>

        <button id="boton-logout" title="Cerrar sesión" onclick="logout()"></button>
    </div>

</aside>




<article>
    <div class="topbar">
        <button id="boton-atras" onclick="history.back()" title="Volver Atrás"></button></a>
        <p><?=$tituloContenido?></p>

    <label class="switch">
        <input id="checkbox-modo-oscuro" onchange="modoOscuroActivado(this.checked)" type="checkbox">
        <span class="slider round"></span>
    </label>

    <script>
        document.getElementById("checkbox-modo-oscuro").checked = getCookieValue("modoOscuroActivado") == "true";
    </script>
    </div>

    <?require_once("contenido_layout/".$vistaContenido)?>


</article>