<?php


namespace App\Repositories;

class JsonDb {
    /**
     * Guardamos las rutas de los archivos contra los que vamos a
     * estar trabajando para luego poder pasarselas como parametro al constructor
     */
    public const string USUARIOS = "users.json";
    public const string MENSAJES = "mensajes.json";
    public const string ASIGNATURAS = "subjects.json";

    private string $rutaArchivo;



    function __construct(string $nombreArchivo) {
        $this->rutaArchivo = storage_path("app/private/". $nombreArchivo);

        //si el archivo solicitado no existe lo creamos vacio
        if(!file_exists($this->rutaArchivo)) {
            file_put_contents($this->rutaArchivo, "");
        }

        $contenidoArchivo = $this->leer();
        if(!isset($contenidoArchivo["ultimoId"]) || !isset($contenidoArchivo["items"])) {
            $this->escribir([
                "ultimoId" => 0,
                "items" => []
            ]);
        }

    }



    /**
     * @return array los datos del json leido como un array clave valor 
     * @return [] un array vacio si el archivo esta vacio o el json no se
     * puede parsear, por ejemplo porque tiene errores de sintaxis
     */
    function leer(): array {
        $textoArchivo = file_get_contents($this->rutaArchivo);

        if(empty($textoArchivo)) {
            return [];
        }

        //no sabemos si el archivo contiene un json valido,
        //intentamos parsearlo y guardar el resultado en un array
        $contenidoArray = json_decode($textoArchivo, true);
        $jsonTieneErrores = $contenidoArray == null;

        if($jsonTieneErrores) {
            return [];
        }

        return $contenidoArray;
        
    }



    /**
     * @param array $contenido array clave valor que se va a transformar en json
     * y se escribira en el archivo
     */
    function escribir(array $contenido) {
        $contenidoJson = json_encode($contenido, JSON_PRETTY_PRINT);
        file_put_contents($this->rutaArchivo, $contenidoJson);
    }
}

?>