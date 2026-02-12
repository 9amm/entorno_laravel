<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DatosPrueba extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:datos-prueba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "inserta datos de prueba en la bd";

    /**
     * Execute the console command.
     */
    public function handle() {
        echo("\n\n");
        $RUTA_ARCHIVO_SQL = "database/sql/01_seed.sql";

        if(file_exists($RUTA_ARCHIVO_SQL)) {
            $contenidoArchivo = file_get_contents($RUTA_ARCHIVO_SQL);
            try {
                $ok = DB::unprepared($contenidoArchivo);
                echo("ok.");
            } catch (QueryException $e) {
                echo("error: ". $e->getMessage());
            }


        } else {
            echo("archivo" . $RUTA_ARCHIVO_SQL ."no existe");
        }

        echo("\n\n");
    }


}
