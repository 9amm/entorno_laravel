<?foreach($mensajesPendientesModerar as $mensaje):?>
<section class="tarjeta" >
    <p class="mensaje-asignatura"><?=htmlspecialchars($mensaje->getAsignatura()->nombre)?></p>
    <p class="mensaje-fecha"><?=htmlspecialchars($mensaje->getFechaCreacionFormateada())?></p>
    <p class="mensaje-usuario">@<?=htmlspecialchars($mensaje->getUsuario()->nombre)?></p>
    <p class="mensaje-contenido"><?=htmlspecialchars($mensaje->contenido)?></p>

    <button id_mensaje="<?=htmlspecialchars($mensaje->id)?>" class="boton" onclick="approveMessage(this)">Aprobar</button>
    <button id_mensaje="<?=htmlspecialchars($mensaje->id)?>" onclick="rejectMessage(this)">Rechazar</button>
</section>


<script>

    function getIdMensaje(boton) {
        return boton.getAttribute("id_mensaje");
    }

    async function enviarPost(ruta) {
        let peticion = await fetch(ruta, {method: "POST"})
    }

    async function approveMessage(boton) {
        let idMensaje = getIdMensaje(boton);
        ruta = `/moderation/${idMensaje}/approve`;
        await enviarPost(ruta);
        location.reload();
    }

    async function rejectMessage(boton) {
        let idMensaje = getIdMensaje(boton);
        ruta = `/moderation/${idMensaje}/reject`;
        await enviarPost(ruta);
        location.reload();
    }
</script>


<?endforeach;?>