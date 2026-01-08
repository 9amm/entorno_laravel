<?php
use App\Models\Mensaje;

/**
 * En este archivo hay funciones asociadas a cada pagina de la red social
 * estas funciones son llamadas desde el router, que les pasa como parametro
 * las partes de la url
 */



/**
 * Carga una vista que se pasa como parametro dentro de una vista base,
 * de esta forma todas las vistas incluyen el doctype, head, css y javascript
 * que son necesarios en todas las vistas
 * Todas las vistas que se cargan pasan por esta funcion
 * Permite pasarle variables a la vista
 * @param $nombreArchivoVista el nombre o la ruta de la vista que se quiere cargar
 * @param $datos un array clave valor que contiene las variables que se utilizan
 * dentro de la vista que queremos cargar, la clave es el nombre de la variable
 * y el valor es el valor de esa variable
 */
function cargarVista($nombreArchivoVista, $datos = []) {
    $pagina = $nombreArchivoVista;
    extract($datos);
    require_once(DIR_BASE."app/Views/base.php");
}



/**
 * Carga la vista del layout principal, con el aside y el contenido que le
 * pasemos como parametro.
 * 
 * La mayoria de paginas de la web tienen la misma estructura, una barra lateral
 * con enlaces de navegacion y a su derecha un contenedor que muestra contenido
 * diferente dependiendo de la pagina en la que estemos.
 * 
 * Tiene sentido tener una vista plantilla con variables para 
 * las partes que cambien y una funcion que se encarga de pasar esos datos
 * 
 * 
 * @param usuarioLogeado necesitamos saber cual es el usuario logueado para
 * mostrar su nombre en el aside
 * @param tituloContenido es el encabezado que se mostrará sobre el contenido
 * @param vistaContenido el nombre de archivo de la vista con el contenido
 * @param datos array-clave valor que contiene las variables que se puedan
 * necesitar la vista. Si por ejemplo la vista de contenido utiliza la 
 * variable "$mensaje" tendremos que pasar un array ["mensaje" => "hola"].
 */
function cargarLayout(User $usuarioLogeado, string $tituloContenido, string $vistaContenido, $datos = []) {
    $datos["usuarioLogeado"] = $usuarioLogeado;
    $datos["tituloContenido"] = $tituloContenido;
    $datos["vistaContenido"] = $vistaContenido;
    cargarVista("layout.php", $datos);
}




/**
 * Esta funcion la llama cuando el recurso solicitado no existe
 */
function noEncontrado() {
    //codigo estado 404, recurso no encontrado
    http_response_code(404);
    cargarVista("errorPredeterminado.php");
}



function inicio() {
    listaMensajes();
}




/**
 * Muestra una vista con todos los mensajes publicados
 */
function listaMensajes() {
    $usuario = AuthController::getUsuarioLogeado();

    if($usuario != null) {
        $archivoMensajes = new MensajesJsonRepository();
        $mensajesPublicados = $archivoMensajes->getByEstado(EstadosMensaje::PUBLICADO);

        if(sizeof($mensajesPublicados) == 0) {
            cargarLayout($usuario, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ningún mensaje publicado."]);
        } else {
            cargarLayout($usuario, "Mensajes","mensajes_inicio.php", ["mensajesPublicados" => $mensajesPublicados]);
        }

    } else {
        AuthController::redirigirALogin();
    }
}





function formularioRegistrarse() {
    if(AuthController::usuarioEstaLogueado()) {
        AuthController::redirigir("/");
    } else {
        cargarVista("registrarse.html");
    }
}




/**
 * Recoge los datos que se envian via POST desde el formulario para registrarse,
 * valida los datos enviados y crea un nueva cuenta.
 */
function registrarse() {
    //si el usuario ya esta logueado no le dejamos acceder a la pagina de registro
    if(!AuthController::usuarioEstaLogueado()) {

        //obtenemos los datos que se envian desde el formulario
        $nombreUsuario = $_POST["nombre"] ?? "";
        $email = $_POST["email"] ?? "";
        $pass = $_POST["pass"] ?? "";
        $rol = $_POST["rol"] ?? "";

        //comprobamos si se han enviado todos los campos del formulario
        if(empty($nombreUsuario) || empty($email) || empty($pass)) {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Todos los campos son obligatorios"]);

        } else if(!Utils::nombreCumpleFormato($nombreUsuario)) {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Nombre de usuario no cumple formato"]);

        } else if(!Utils::emailCumpleFormato($email)) {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Email no válido"]);

        } else if($rol != Rol::ALUMNO && $rol != Rol::PROFESOR) {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Rol no válido"]);
        } else {

            //comprobamos que el nombre de usuario no lo este utilizando otro usuario
            $archivoUsuarios = new UsersJsonRepository();
            //si encontramos en la bd a alguien con ese nombre significa que esta ocupado
            $nombreDisponible = $archivoUsuarios->getByNombre($nombreUsuario) == null;

            if($nombreDisponible) {

                //comprobamos si hay un usuario en la bd con ese email
                $emailDisponible = $archivoUsuarios->getByEmail($email) == null;

                //mensaje generico para no dar informacion sobre que emails hay registrados
                if($emailDisponible) {

                    if(Utils::contrasenaHasheadaCumpleFormato($pass)) {
                        //si llega hasta este punto los datos son validos, guardamos el usuario en bd


                        //creamos un usuario con los datos del formluario
                        $nuevoUsuario = new User($nombreUsuario, $email, $pass, $rol);
                        //guardamos el usuario en la bd
                        $archivoUsuarios->save($nuevoUsuario);

                        //guardamos en la sesion el usuario que se acaba de crear para que en la
                        //proximas peticiones no se le pida iniciar sesion
                        AuthController::setUsuarioLogeado($nuevoUsuario);
                        AuthController::redirigir("/");

                    } else {
                        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "La contraseña no cumple con el formato solicitado"]);
                    }

                } else {
                    cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Email no válido"]);
                }

            } else {
                cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Nombre de usuario no disponible"]);
            }
        }
    } else {
        AuthController::redirigir("/");
    }
}




/**
 * Carga una vista con un formulario de inicio de sesion
 */
function formularioLogin() {
    //si el usuario ya esta logueado no lo dejamos acceder al formulario de login
    if(AuthController::usuarioEstaLogueado()) {
        AuthController::redirigir("/");
    } else {
        cargarVista("login.html");
    }
}




/**
 * Inicia la sesion de un usuario a partir de los datos enviados via POST
 */
function login() {
    if(!AuthController::usuarioEstaLogueado()) {
        $usuario = $_POST["usuario"] ?? "";

        //la contraseña que se envia hasheada desde el frontend
        $pass = $_POST["pass"] ?? "";

        if(!empty($usuario) && !empty($pass)) {
            $archivoUsuarios = new UsersJsonRepository();
            $usuarioEncontrado = $archivoUsuarios->getByNombre($usuario);

            //si no se ha encontrado un usuario con el nombre introducido en el formulario
            if($usuarioEncontrado != null && $pass == $usuarioEncontrado->passHasheada) {
                AuthController::setUsuarioLogeado($usuarioEncontrado);

                //buscamos en la bd si este usuario tiene el modo oscuro activado y enviamos al navegador
                //una cookie con el valor obtenido, luego desde js podemos leer el valor de la cookie y cambiar
                //los colores de la pagina dependiendo de si el modo oscuro esta activado o no
                setcookie("modoOscuroActivado", $usuarioEncontrado->getModoOscuroActivado() ? "true":"false");
                session_regenerate_id(true);

                $rutaRedirigir = AuthController::getOrigenRedireccion() ?? "/";

                AuthController::redirigir($rutaRedirigir);
            } else {
                cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Datos de inicio de sesión no válidos"]);
            }
        } else {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Cubre todos los campos"]);
        }
    } else {
        AuthController::redirigir("/");
    }
}





function logout() {
    AuthController::logout();
    AuthController::redirigir("/login");
}




/**
 * Muestra todos los mensajes publicados a partir del id de una asignatura
 * @param id el id de la asignatura
 */
function listaAsignaturas($id = ""){
    $usuario = AuthController::getUsuarioLogeado();

    if($usuario != null) {
        $archivoAsignaturas = new AsignaturasJsonRepository();

        //si no se pasa como parametro el id de una asignatura en concreto mostramos todas
        if(empty($id)) {
            $asinaturas = $archivoAsignaturas->getAll();

            //si no hay asignaturas
            if(sizeof($asinaturas) == 0) {
                cargarLayout($usuario, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ninguna asignatura."]);
            } else {
                cargarLayout($usuario, "Asignaturas", "subjects.php", ["asignaturas" => $asinaturas]);
            }

        } else {

            //buscamos en la bd la asignatura con el id que se pase como parametro
            $asignatura = $archivoAsignaturas->getById($id);
            //si no encontramos ninguna asignatura
            if($asignatura != null) {
                //obtenemos todos los mensajes publicados de esa asignatura
                $mensajes = $asignatura->getMensajesPorEstado(EstadosMensaje::PUBLICADO);
                //guardamos cuantos mensajes son
                $numMensajes = sizeof($mensajes);

                $variablesVista = [
                    "asignatura" => $asignatura,
                    "mensajes" => $mensajes,
                    "numMensajes" => $numMensajes
                ];
                cargarLayout($usuario, $asignatura->nombre, "subject.php", $variablesVista);

            } else {
                cargarLayout($usuario, "Asignturas", "mensaje_warning.php", ["mensaje" => "Asignatura no encontrada"]);
            }
        }
    }else {
        AuthController::redirigirALogin();
    }
}



/**
 * Muestra una vista con un formulario para
 * crear nuevos mensajes.
 */
function formularioCrearMensaje($accion = "") {
    $usuario = AuthController::getUsuarioLogeado();

    if($usuario != null) {

        if($accion == "new") {
            $asignaturas = new AsignaturasJsonRepository()->getAll();
            cargarLayout($usuario, "Crear mensaje", "crear_mensaje.php", ["asignaturas" => $asignaturas]);
        } else {
            noEncontrado();
        }
    } else {
        AuthController::redirigirALogin();
    }
}



/**
 * Se encarga de recoger y comprobar los datos que se envian via POST desde el 
 * formulario para crear mensajes. 
 */
function crearMensaje() {
    $usuarioLogeado = AuthController::getUsuarioLogeado();

    if($usuarioLogeado != null) {

        $idAsignatura = $_POST["id_asignatura"] ?? "";
        $contenidoMensaje = $_POST["mensaje"] ?? "";

        if(empty($idAsignatura) || empty($contenidoMensaje)) {
            cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Todos los campos son obligatorios."]);

        } else if(!Mensaje::tieneLongitudValida($contenidoMensaje)) {
            cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Longitud del mensaje no valida."]);
        } else {
            $idAsignturaExiste = new AsignaturasJsonRepository()->getById($idAsignatura) != null;

            if($idAsignturaExiste) {
                $idUsuarioLogeado = $usuarioLogeado->id;

                if(Mensaje::contienePalabrasVetadas($contenidoMensaje)) {
                    $estado = EstadosMensaje::PELIGROSO;
                    $mensaje = "Hemos detectado que el mensaje contiene palabras vetadas, el mensaje queda pendiente de revisión por parte de un moderador.";
                    cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => $mensaje]);

                }else{
                    $estado = EstadosMensaje::PENDIENTE;   
                }
                
                $mensaje = new Mensaje(
                    contenido: $contenidoMensaje,
                    idAsignatura: $idAsignatura,
                    idUsuario: $idUsuarioLogeado,
                    estadoMensaje: $estado,
                    timestampCreacion: time()
                );
                
                //guardamos el mensaje en la bd
                new MensajesJsonRepository()->save($mensaje);
                cargarLayout($usuarioLogeado, "Error", "mensaje_ok.php", ["mensaje" => "Mensaje creado correctamente, queda pendiente de moderar."]);

            } else {
                cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Asignatura no encontrada."]);
            }
        }
    } else {
        echo("autenticación requerida");
    }
}





/**
 * Muestra una pagina con un listado de mensajes pendientes de moderar,
 * comprobamos que el usuario esta logueado y tiene el rol necesario (profesor). 
 */
function listaMensajesModerar() {
    $usuarioLogeado = AuthController::getUsuarioLogeado();

    if ($usuarioLogeado == null) {
        AuthController::redirigirALogin();
    } elseif (!$usuarioLogeado->esProfesor()) {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "No tienes permiso"]);
    } else {
        $mensajesPendientesModerar = new MensajesJsonRepository()->getByEstados([EstadosMensaje::PENDIENTE, EstadosMensaje::PELIGROSO]);

        if(sizeof($mensajesPendientesModerar) == 0) {
            cargarLayout($usuarioLogeado, "Mensajes", "mensaje_warning.php", ["mensaje" => "Aún no hay ningún mensaje para moderar."]);
        } else {
            cargarLayout($usuarioLogeado, "Moderación", "mensajes_moderar.php", ["mensajesPendientesModerar" => $mensajesPendientesModerar]);
        }
    }
}




/**
 * Esta funcion es la que permite aprobar o rechazar mensajes desde 
 * el panel de moderacion.
 * @param idMensaje el id del mensaje que se quiere aprobar o rechazar
 * @param accion puede ser "approve" o "reject"
 * Los parametros de esta funcion son pasados por el router, que los
 * extrae de la url.
 * Ej: 
 *  POST /1/approve
 */
function moderar($idMensaje = "", $accion = "") {
    $usuario = AuthController::getUsuarioLogeado();

    if($usuario == null) {
        echo("autenticación requerida");
    }else if (empty($idMensaje) || ($accion != "approve" && $accion != "reject")) {
        noEncontrado();
    } else if (!$usuario->esProfesor()) {
        echo("no tienes permiso");
    } else {
        $archivoMensajes = new MensajesJsonRepository();
        $mensaje = $archivoMensajes->getById($idMensaje);

        if($mensaje == null) {
            echo("mensaje no encontrado");
        } else if(!$mensaje->tieneAlgunoDeLosEstados([EstadosMensaje::PENDIENTE, EstadosMensaje::PELIGROSO])) {
            echo("el mensaje no esta pendiente de moderar");
        } else {

            if($accion == "approve") {
                $mensaje->estadoMensaje = EstadosMensaje::PUBLICADO;
            } else if($accion == "reject") {
                $mensaje->estadoMensaje = EstadosMensaje::RECHAZADO;
            }

            $archivoMensajes->update($mensaje);
        }
    }
}

/**
 * Para cada cuenta de la red social guardamos que tema prefiere,
 * si prefiere modo claro o prefiere modo oscuro.
 * 
 * El usuario puede cambiar el tema desde la interfaz, cuando lo haga
 * necesitamos guardar ese cambio en el servidor para que cuando inicie
 * sesion desde otros dispositivos la web se muestre con el tema seleccionado.
 * 
 * Esta funcion es la que se encarga de guardar el nuevo cambio de tema en el servidor,
 * lee los datos que se envian en el cuerpo de la peticion POST, valida que cumpan
 * un formato y los guarda.
 */
function setTema() {
    if (!AuthController::usuarioEstaLogueado()) {
        echo("autenticacion requerida");
    } else {
        $modoOscuroActivado = $_POST["modoOscuroActivado"] ?? "";

        if ($modoOscuroActivado != "true" && $modoOscuroActivado != "false") {
            echo("valor no valido");
        } else {
            $usuario = AuthController::getUsuarioLogeado();
            $usuario->setModoOscuroActivado($modoOscuroActivado == "true");
            new UsersJsonRepository()->update($usuario);
        }
    }
}

?>