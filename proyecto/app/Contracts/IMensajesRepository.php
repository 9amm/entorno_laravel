<?php

namespace App\Contracts;
use App\Models\Mensaje;
use App\Models\User;

interface IMensajesRepository {

    /**
     * @return array un array de objetos Mensaje
     */
    function getAll(): array;


    function save(Mensaje $mensaje): void;

    function update(Mensaje $mensaje);

    function getById($id): ?Mensaje;

    /**
     * Devuelve un array con todos los mensajes que ha publicado el usuario que
     * se pase como parametro
     * @return array un array de objetos Mensaje
     */
    function getByUser(User $usuario): array;



    /**
     * Devuelve todos los mensajes con el estado que se pase como parametro
     * @see EstadosMensaje
     */
    function getByEstado(string $estado): array;

    /**
     * devuelve los mensajes que tienen un estado incluido en en una lista
     * de estados que se pasan como parametro
     * 
     * util si por ejemplo quieres obtener una lista con los mensajes
     * con estado pendiente y peligroso
     * 
     * @param array una lista de estados de mensaje
     * @see EstadosMensaje
     * @return array una lista con los mensajes que tienen de estado alguno
     * de los estados que se pasan como parametro
     */
    function getByEstados(array $estados): array;

    /**
     * a partir del id de una asignatura devuelve un array con todos los mensajes
     * que existen sobre esa asignatura, sin importar su estado
     */
    function getByAsignatura(int $idAsignatura): array;


}

?>