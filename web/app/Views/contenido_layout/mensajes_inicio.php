<?foreach($mensajesPublicados as $mensaje):?>
<section class="tarjeta">
    <p class="mensaje-asignatura"><?=htmlspecialchars($mensaje->getAsignatura()->nombre)?></p>
    <p class="mensaje-fecha"><?=htmlspecialchars($mensaje->getFechaCreacionFormateada())?></p>
    <p class="mensaje-usuario">@<?=htmlspecialchars($mensaje->getUsuario()->nombre)?></p>
    <p class="mensaje-contenido"><?=htmlspecialchars($mensaje->contenido)?></p>
</section>
<?endforeach;?>