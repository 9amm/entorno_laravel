<?php

interface IAsignaturasRepository {

    function getAll(): array ;


    function getById($id): ?Asignatura ;

    function save(Asignatura $asignatura): void;

}
?>