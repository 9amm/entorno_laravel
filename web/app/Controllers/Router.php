<?php
/**
 * Divide la ruta en partes 
 * Ej:
 * si la url es "moderation/3/approve" 
 * devuelve: ["moderation", 3, "approve"]
 */
function getPartesUrl($url) {
    return explode("/", trim($url, "/"));
}

/**
 * 
 * Ejecuta una funcion de PageController dependiendo del metodo y la ruta
 * solicitada, se encarga de renderiza una pagina u otra
 * 
 * La ruta ruta solicitada seria por ejemplo "/login", "/subjects"...
 * A esta funcion se le pasan como parametros todas las partes de la url menos la primera
 * Ejemplo:
 * Si la funcion moderation() se ejecuta cuando se envia un GET a "/moderation/2/reject"
 * a la funcion recibira como parametros 2, "reject"
 * @param metodo el metodo de la peticion (GET, POST...)
 * @param url la ruta solicitada (/moderation/3/approve, /logout ...)
 */
function procesarRuta($metodo, $url) { 
    $partesUrl = getPartesUrl($url);
    //guardamos la primera parte de la url, esto es lo que usamos para saber que
    //funcion hay que llamar
    $primeraParteUrl = $partesUrl[0] ?? "";
    
    //guardamos los parametros que se van a utilizar en la funcion
    $parametros = array_slice($partesUrl, 1);

    if($metodo == "GET") {
        //si la url esta vacia mostramos la pagina de inicio
        if($primeraParteUrl == "") {
            inicio();
        } else if($primeraParteUrl == "register") {
            formularioRegistrarse(...$parametros);
        } else if($primeraParteUrl == "login") {
            formularioLogin(...$parametros);
        } else if($primeraParteUrl == "messages") {
            formularioCrearMensaje(...$parametros);
        } else if($primeraParteUrl == "subjects") {
            listaAsignaturas(...$parametros);
        } else if($primeraParteUrl == "moderation") {
            listaMensajesModerar(...$parametros);
        } else {
            //si no se encuentra la ruta solicitada
            noEncontrado();
        }

    } else if($metodo == "POST") {
        if($primeraParteUrl == "register") {
            registrarse(...$parametros);
        } else if($primeraParteUrl == "login") {
            login(...$parametros);
        } else if($primeraParteUrl == "logout") {
            logout(...$parametros);
        } else if($primeraParteUrl == "messages") {
            crearMensaje(...$parametros);
        } else if($primeraParteUrl == "moderation") {
            moderar(...$parametros);
        } else {
            noEncontrado();
        }
    }

}

?>