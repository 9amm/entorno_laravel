<?php

namespace App\Models;


class Asignatura {
    public ?int $id;
    public string $nombre;

    function __construct(string $nombre, ?int $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
    }



}


?>