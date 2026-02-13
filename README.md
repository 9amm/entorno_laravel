# README

Version de php que usamos 8.4.15

Versión de laravel 12.39

# ¿Por que laravel?

Se ha elegido **Laravel** frente a otras alternativas como **Slim** o **Symfony** por su equilibrio entre facilidad de uso y potencia. Mientras que Slim es un micro-framework que hubiera requerido la instalación manual de múltiples paquetes externos para gestionar sesiones y plantillas, Laravel ofrece una solución integral que acelera el desarrollo. Por otro lado, aunque Symfony es un framework muy robusto, su curva de aprendizaje y configuración de servicios es más compleja para los objetivos de esta práctica.

# Patrones de diseño aplicados

MVC: MVC es un patrón a que separa Modelo (datos), Vista (visual) y lógica (Controlador).

Resuelve el problema del código desordenado y acoplado, donde la lógica, los datos y la interfaz están mezclados, haciendo la aplicación difícil de mantener y modificar sin romper otras partes del programa.

Patron Repository: 

Este patrón nos permite tener una capa intermedia entre la aplicación y los datos, si por ejemplo tenemos que cambiar de json a una bd mysql solo tenemos que cambiar una parte del codigo.

Creamos interfaces como IUserRepository o IMessagesRepository con métodos básicos (getAll(), getById(), save()) que devuelven objetos del modelo y luego implementaciones concretas como UsersJsonRepository que implementan estas funciones leyendo y escribiendo los datos desde el JSON. 

La gracia de usar este patron es que si en lugar usar un archivo json para guardar los usuarios queremos guardarlos en la base de datos unicamente tenemos que crear clases especificas que implementen las interfaces de los repositorios solo que en lugar de sacar los datos de los archivos json los saque desde la base de datos mysql p.e

También hemos aprovechado el sistema inyección de dependencias de laravel, si un método de un  controlador necesita un repositorio por ejemplo (UsersJsonRepository) lo anadirmos como parametro de ese metodo y laravel se encarga automáticamente que crear un objeto y pasarselo como parametro a ese metodo:

Ej: Aqui laravel va a inyectar un objeto de tipo IAsginaturasRepository, es decir cualquier clase que implemente esta interfaz, como puede ser AsignaturasJsonRepository o en un futuro otra clase como AsignaturasMysqlRepository, la gracia es que no le estamos pidiendo un tipo en concreto.

```php
class AsignaturasController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(IAsignaturasRepository $repositorioAsignaturas) {
        $asinaturas = $repositorioAsignaturas->getAll();
        
    //...
```

Usando bind es la forma en la que le decimos a laravel que objeto tiene que injectar cuando se le pida un objeto de tipo IAsignaturasRepository, hacemos que devuelva AsignturasJsonRepository, pero en el futuro podemos hacer que devuelva AsignaturasMysqlRepository y no tendriamos que cambiar las otras partes del codigo.

```php
  class RepositoryServiceProvider extends ServiceProvider {

    $this->app->bind(IAsignaturasRepository::class, function ($app) {
        return new AsignaturasJsonRepository();
    });

```

**POO:** clases modelo (User, Message), herencia, encapsulación

Tenemos varias clases como: Asignatura, Mensaje, Rol, User con propiedades y metodos con logica. Cuando obtenemos datos de un repositorio el repositorio el repositorio devuelve modelos automaticamente lo que hace que todo sea mucho más facil.

En estos modelos no estamos usando herencia pero si que implementamos la interfaz Authenticable en la clase Users para poder

**Generación dinámica de interfaz:** componentes/parciales reutilizables, layouts, helpers

Todas las vistas se basan en una plantilla principal que contiene la estructura HTML básica: header, body, CSS y JavaScript. A partir de esta base, hemos dividido en componentes las secciones que se utilizan en varias vistas, como la barra lateral de navegación, la lista de asignaturas o los mensajes. De esta manera, si queremos mostrar un mensaje en varias vistas, solo necesitamos llamar al componente <x-mensaje> y pasarle como atributos HTML los datos que cambian en cada caso, por ejemplo, la fecha o el usuario que lo ha publicado.

Los helpers mas útiles que hemos utilizado:

`route()`: Desde el router le hemos asignado a cada ruta un nombre, utilizando el helper `route("nombre_ruta")` podemos obtener la ruta a partir de ese nombre. Esto es muy útil porque podemos hacer que todas las vistas que necesiten una ruta (p.e. post de un formulario, un enlace HTML…) se obtengan a partir del nombre en lugar de hardcodear la ruta directamente en las vistas, así si tenemos que cambiar una ruta, solo hay que cambiarla en un sitio, en el router.

redirect(): para redirigir a una url que se pase como parametro, tambien se puede combinar con route() para no hardcodear urls.

app()→make(): este metodo devuelve el contendor de laravel, que es la parte que se encarga de resolver las dependencias, es decir cuando nosotros en un método o en un constructor añadimos como parametro dependencias, el contenedor es quien se encarga de crearlas y pasarlas como parametro al metodo o constructor automaticamente, el problema es que lo de declarar las dependencias como parametros y laravel las inyecte automaticamente solo funciona si la clase en la que estamos haciendo la inyeccion es una clase que hereda de alguna de las clases de laravel, como por ejemplo Controller o Middleware, si tenemos clases propias (como por ejemplo modelos) tenemos que llamar al contenedor de forma manual y para eso tenemos que utilizar este helper, que tiene el metodo make() al que le podemos pasar una referencia a una clase y el la resuelve.

abort(): sirve para lanzar excepciones, por ejemplo abort(404) lanza una excepcion “not found”.

session(): lo usamos para guardar datos en la sesion en lugar de usar $SESSION de php

url()→previous(): cuando un usuario intenta acceder a una parte de la red social y no esta autenticado lo redirigimos a login y luego usamos url()→previous() para redirigirlo de vuelva a donde estaba intentando acceder antes, cuando no estaba autenticado

## 

# Listado de rutas y roles


Autenticación

| Métdo | Ruta      | Descripción                           | Autenticación |
| ----- | --------- | ------------------------------------- | ------------- |
| GET   | /login    | Formulario de incio de sesión         | No            |
| POST  | /login    | Procesar inicio de sesión del usuario | No            |
| GET   | /register | Formulario de registro                | No            |
| POST  | /register | Procesar registro del usuario         | No            |
| POST  | /logout   | Cerrar la sesión del usuario          | Si            |


Página principal

| Métdo | Ruta | Descripción      | Autenticación | Rol   |
| ----- | ---- | ---------------- | ------------- | ----- |
| GET   | /    | Página principal | Si            | Todos |


Asignaturas

| Métdo | Ruta                  | Descripción                       | Autenticación | Rol   |
| ----- | --------------------- | --------------------------------- | ------------- | ----- |
| GET   | /subjects             | Listado de todas las asignaturas  | Si            | Todos |
| GET   | /subjects{asignatura} | Mensajes de asignatura específica | Si            | Todos |


Mensajes

| Métdo | Ruta          | Descripción                       | Autenticación | Rol   |
| ----- | ------------- | --------------------------------- | ------------- | ----- |
| POST  | /messages     | Publicar un nuevo mensaje         | Si            | Todos |
| GET   | /messages/new | Formulario de creación de mensaje | Si            | Todos |


Moderación

| Métdo | Ruta                           | Descripción                             | Autenticación | Rol      |
| ----- | ------------------------------ | --------------------------------------- | ------------- | -------- |
| GET   | /moderation                    | Lista de mensajes pendientes de moderar | Si            | Profesor |
| POST  | /moderation/{mensaje}/{accion} | Aprobar o rechazar                      | Si            | Profesor |


Tema

| Métdo | Ruta   |
| ----- | ------ |
| POST  | /theme |


## Explicación de validación y sanitización implementada.

Usamos Blade, para prevenir ataques XSS (Cross-Site Scripting), se ha eliminado el uso de `htmlspecialchars()` manual. En su lugar, se utiliza el motor de plantillas Blade con la sintaxis 

`{{ $variable }}`. Laravel escapa automáticamente cualquier contenido antes de renderizarlo en el navegador, neutralizando scripts maliciosos.

Seguridad de sesion, laravel gestiona la rotación de IDs de sesión y la protección contra ataques CSRF mediante el middleware `VerifyCsrfToken`, que valida un token único en cada petición POST.

## Usuarios de prueba (al menos 1 alumno y 1 profesor).

| Rol Usuarios Prueba | Nombre | Contraseña |
| --- | --- | --- |
| Alumno | alumno1 | @Holaquetal |
| Profesor | profesor1 | @Holaquetal |

## Intruciones para generar documentación con Doxygen.
Primero entramos al terminal en el contenedor desde la raíz del proyecto y ejecutamos el comando: "doxygen", esto genera automaticamente una carpeta en docs con toda la nueva documentación.
Para encontrarlo tenemos que entrar en docs/html y abrir el archivo index.html.

## Instalacion

Clonar el proyecto y situarse en la raiz


Ejecutar “docker compose up”



