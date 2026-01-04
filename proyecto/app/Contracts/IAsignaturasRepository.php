<?php

namespace App\Contracts;
use App\Models\Asignatura;

interface IAsignaturasRepository {

    function getAll(): array ;


    function getById($id): ?Asignatura ;

    function save(Asignatura $asignatura): void;

}
?>