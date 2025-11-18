<?php

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





function listaMensajes() {
    AuthController::loginObligatorio();
    $archivoMensajes = new Mensajes();
    $mensajesPublicados = $archivoMensajes->getByEstado(EstadosMensaje::PUBLICADO);

    $usuario = AuthController::getUsuarioLogeado();
    if(sizeof($mensajesPublicados) == 0) {
        cargarLayout($usuario, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ningún mensaje publicado."]);
    } else {
        cargarLayout($usuario, "Mensajes","mensajes_inicio.php", ["mensajesPublicados" => $mensajesPublicados]);
    }
}





function formularioRegistrarse() {
    if(AuthController::estaLogueado()) {
        AuthController::redirigir("/");
    }
    cargarVista("registrarse.html");
}





function registrarse() {
    //si el usuario ya esta logueado no le dejamos acceder a la pagina de registro
    if(AuthController::estaLogueado()) {
        AuthController::redirigir("/");
    }

    //obtenemos los datos que se envian desde el formulario
    $nombreUsuario = $_POST["nombre"] ?? "";
    $email = $_POST["email"] ?? "";
    $pass = $_POST["pass"] ?? "";
    $rol = $_POST["rol"] ?? "";

    //comprobamos si se han enviado todos los campos del formulario
    if(empty($nombreUsuario) || empty($email) || empty($pass) || empty($rol)) {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Todos los campos son obligatorios"]);

    }else if(!Utils::nombreCumpleFormato($nombreUsuario)) {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Nombre de usuario no cumple formato"]);

    }else if(!Utils::emailCumpleFormato($email)) {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Email no válido"]);

    }else if($rol != Rol::ALUMNO && $rol != Rol::PROFESOR) {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Rol no válido"]);
        
    } else {

        //comprobamos que el nombre de usuario no lo este utilizando otro usuario
        $archivoUsuarios = new Users();
        //si encontramos en la bd a alguien con ese nombre significa que esta ocupado
        $nombreDisponible = $archivoUsuarios->getByNombre($nombreUsuario) == null;

        if($nombreDisponible) {
            //comprobamos si hay un usuario en la bd con ese email
            $emailDisponible = $archivoUsuarios->getByEmail($email) == null;

            if($emailDisponible && Utils::contrasenaCumpleFormato($pass)) {
                //hasheamos la contrasena antes de guardarla en la bd
                $passHasheada = password_hash($pass, PASSWORD_BCRYPT);
                //creamos un usuario con los datos del formluario
                $nuevoUsuario = new User($nombreUsuario, $email, $passHasheada, $rol);
                //guardamos el usuario en la bd
                $archivoUsuarios->save($nuevoUsuario);

                //guardamos en la sesion el usuario que se acaba de crear para que en la
                //proximas peticiones no se le pida iniciar sesion
                AuthController::setUsuarioLogeado($nuevoUsuario);
                AuthController::redirigir("/");
            } else {
                cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Datos de registro no válido"]);
            }

        } else {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Nombre de usuario no disponible"]);
        }
    }
}





function formularioLogin() {
    //si el usuario ya esta logueado no lo dejamos acceder al formulario de login
    if(AuthController::estaLogueado()) {
        AuthController::redirigir("/");
    } else{
        cargarVista("login.html");
    }
}





function login() {
    if (AuthController::estaLogueado()) {
        AuthController::redirigir("/");
    } else {
        $usuario = $_POST["usuario"] ?? "";
        $pass = $_POST["pass"] ?? "";

        $datosVacios = empty($usuario) || empty($pass);

        if (!$datosVacios) {
            $archivoUsuarios = new Users();
            $usuarioEncontrado = $archivoUsuarios->getByNombre($usuario);
            $nombreUsuarioExiste = $usuarioEncontrado != null;

            //si no se ha encontrado un usuario con el nombre introducido en el formulario
            if ($nombreUsuarioExiste && password_verify($pass, $usuarioEncontrado->passHasheada)) {
                AuthController::setUsuarioLogeado($usuarioEncontrado);

                session_regenerate_id(true);

                $rutaRedirigir = $_SESSION["loginRedirigir"] ?? "/";
                unset($_SESSION["loginRedirigir"]);

                AuthController::redirigir($rutaRedirigir);
            } else {
                cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Datos de inicio de sesión no válidos"]);
            }
        } else {
            cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "Cubre todos los campos"]);
        }
    }
}





function logout() {
    AuthController::logout();
    AuthController::redirigir("/login");
}





function listaAsignaturas($id = ""){
    AuthController::loginObligatorio();
    $usuario = AuthController::getUsuarioLogeado();
    $archivoAsignaturas = new Asignaturas();

    //si no se pasa como parametro el id de una asignatura en concreto mostramos todas
    if(empty($id)) {
        $asinaturas = $archivoAsignaturas->getAll();

        //si no hay asignaturas
        if(sizeof($asinaturas) > 0) {
            cargarLayout($usuario, "Asignaturas", "subjects.php", ["asignaturas" => $asinaturas]);
        } else {
            cargarLayout($usuario, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ninguna asignatura."]);
        }

    } else {

        //buscamos en la bd la asignatura con el id que se pase como parametro
        $asignatura = $archivoAsignaturas->getById($id);
        $asignaturaEncontrada = $asignatura != null;
        //si no encontramos ninguna asignatura
        if($asignaturaEncontrada) {
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
}




function formularioCrearMensaje($accion = "") {
    AuthController::loginObligatorio();

    if($accion == "new") {
        $asignaturas = new Asignaturas()->getAll();
        $usuario = AuthController::getUsuarioLogeado();
        cargarLayout($usuario, "Crear mensaje", "crear_mensaje.php", ["asignaturas" => $asignaturas]);
    } else {
        noEncontrado();
    }
}




function crearMensaje() {
    AuthController::loginObligatorio();

    $usuarioLogeado = AuthController::getUsuarioLogeado();

    $idAsignatura = $_POST["id_asignatura"] ?? "";
    $contenidoMensaje = $_POST["mensaje"] ?? "";

    if(empty($idAsignatura) || empty($contenidoMensaje)) {
        cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Todos los campos son obligatorios."]);
    } else if(!Mensaje::tieneLongitudValida($contenidoMensaje)) {
        cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Longitud del mensaje no valida."]);
    } else {

        $idAsignturaExiste = new Asignaturas()->getById($idAsignatura) != null;

        if($idAsignturaExiste) {

            if(Mensaje::contienePalabrasVetadas($contenidoMensaje)) {
                $estado = EstadosMensaje::PENDIENTE;
                $mensaje = "Hemos detectado que el mensaje contiene palabras vetadas, el mensaje queda pendiente de revisión por parte de un moderador.";
                cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => $mensaje]);

            }else{
                $estado = EstadosMensaje::PUBLICADO;   
            }
            
            $idUsuarioLogeado = $usuarioLogeado->id;
            $mensaje = new Mensaje(
                contenido: $contenidoMensaje,
                idAsignatura: $idAsignatura,
                idUsuario: $idUsuarioLogeado,
                estadoMensaje: $estado,
                timestampCreacion: time()
            );
            
            //guardamos el mensaje en la bd
            new Mensajes()->save($mensaje);
            cargarLayout($usuarioLogeado, "Error", "mensaje_ok.php", ["mensaje" => "Mensaje publicado correctamente."]);

        } else {
            cargarLayout($usuarioLogeado, "Error", "mensaje_warning.php", ["mensaje" => "Asignatura no encontrada."]);
        }
    }
}






function listaMensajesModerar() {
    AuthController::loginObligatorio();

    $usuarioLogeado = AuthController::getUsuarioLogeado();

    if($usuarioLogeado->esProfesor()) {

        $mensajesPendientesModerar = new Mensajes()->getByEstado(EstadosMensaje::PENDIENTE);

        if(sizeof($mensajesPendientesModerar) == 0) {
            cargarLayout($usuarioLogeado, "Mensajes","mensaje_warning.php", ["mensaje" => "Aún no hay ningún mensaje para moderar."]);
        } else {
            cargarLayout($usuarioLogeado, "Moderación", "mensajes_moderar.php", ["mensajesPendientesModerar" => $mensajesPendientesModerar]);
        }
    } else {
        cargarVista("contenido_layout/mensaje_warning.php", ["mensaje" => "No tienes permiso"]);
    }
}





function moderar($idMensaje = "", $accion = "") {
    AuthController::loginObligatorio();
    if(empty($idMensaje) || $accion != "approve" && $accion != "reject") {
        noEncontrado();

    }else if(!AuthController::getUsuarioLogeado()->esProfesor()) {
        echo("no tienes permiso");

    }  else {
        $archivoMensajes = new Mensajes();
        $mensaje = $archivoMensajes->getById($idMensaje);

        if($mensaje == null) {
            echo("mensaje no encontrado");
        } else if($mensaje->estadoMensaje != EstadosMensaje::PENDIENTE) {
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

?>