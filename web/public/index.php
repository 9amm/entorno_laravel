<?php
//Configura las cookies de sesión con atributos de seguridad
session_set_cookie_params(["samesite" => "Lax", "httponly" => true]);
session_start();

//importamos todas las clases que vamos a utilizar
require_once("../config/app.php");
require_once(DIR_BASE."app/Controllers/Utils.php");
require_once(DIR_BASE."app/Models/JsonDb.php");
require_once(DIR_BASE."app/Models/User.php");
require_once(DIR_BASE."app/Models/Users.php");

require_once(DIR_BASE."app/Models/Asignatura.php");
require_once(DIR_BASE."app/Models/Asignaturas.php");

require_once(DIR_BASE."app/Models/Mensaje.php");
require_once(DIR_BASE."app/Models/Mensajes.php");

require_once(DIR_BASE."app/Controllers/AuthController.php");
require_once(DIR_BASE."app/Controllers/PageController.php");
require_once(DIR_BASE."app/Controllers/Router.php");



//obtiene el método HTTP de la petición actual (GET, POST, etc.)
$metodo = $_SERVER["REQUEST_METHOD"];
//obtiene la ruta solicitada por el usuario (/register, /logout ...)
$rutaSolicitada = $_SERVER["REQUEST_URI"];

//se encarga de mostrar una pagina u otra dependiendo del metodo y la ruta solicitada
procesarRuta($metodo, $rutaSolicitada);


?>