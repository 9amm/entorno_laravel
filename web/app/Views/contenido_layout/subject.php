

<h1><?=htmlspecialchars($asignatura->nombre)?></h1>
<p><?=htmlspecialchars($numMensajes." ".($numMensajes == 1 ? "mensaje":"mensajes"))?></p>

<?foreach($mensajes as $mensaje):?>
    <section class="tarjeta">
        <p class="mensaje-asignatura"><?=htmlspecialchars($mensaje->getAsignatura()->nombre)?></p>
        <p class="mensaje-fecha"><?=htmlspecialchars($mensaje->getFechaCreacionFormateada())?></p>
        <p class="mensaje-usuario">@<?=htmlspecialchars($mensaje->getUsuario()->nombre)?></p>
        <p class="mensaje-contenido"><?=htmlspecialchars($mensaje->contenido)?></p>
    </section>

<?endforeach;?>

