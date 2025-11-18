<? foreach ($asignaturas as $asignatura): ?>
    <a class="tarjeta-asignatura tarjeta tarjeta-hover" href="/subjects/<?=htmlspecialchars($asignatura->id)?>">
        <?= htmlspecialchars($asignatura->nombre) ?>
    </a>
<? endforeach; ?>