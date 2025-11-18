# Red Social Interna - P8
Red social interna mínima desarrollada en PHP con sesiones, autenticación, validación de seguridad y moderación de contenidos.


##  Estructura del proyecto

```
red_social/
├── docker-compose.yaml          # Configuración de contenedores
├── php_apache.Dockerfile        # Imagen Docker del servidor
├── configuracion/
│   ├── 000-default.conf        # Configuración Apache
│   └── xdebug_configuracion.ini # Configuración XDebug
├── web/
│   ├── app/
│   │   ├── Controllers/        # Lógica de negocio
│   │   │   ├── AuthController.php      # Autenticación
│   │   │   ├── PageController.php      # Manejadores de páginas
│   │   │   ├── Router.php              # Enrutador
│   │   │   └── Utils.php               # Utilidades
│   │   ├── Models/             # Acceso a datos
│   │   │   ├── JsonDb.php              # Base de datos JSON
│   │   │   ├── User.php                # Modelo de usuario
│   │   │   ├── Users.php               # Gestión de usuarios
│   │   │   ├── Asignatura.php          # Modelo de asignatura
│   │   │   ├── Asignaturas.php         # Gestión de asignaturas
│   │   │   ├── Mensaje.php             # Modelo de mensaje
│   │   │   └── Mensajes.php            # Gestión de mensajes
│   │   └── Views/              # Plantillas
│   │       ├── base.php                # Plantilla base (HTML structure)
│   │       ├── layout.php              # Layout principal con sidebar
│   │       ├── login.html              # Formulario de login
│   │       ├── registrarse.html        # Formulario de registro
│   │       └── contenido_layout/       # Vistas de contenido
│   │           ├── crear_mensaje.php
│   │           ├── mensaje_ok.php
│   │           ├── mensaje_warning.php
│   │           ├── mensajes_inicio.php
│   │           ├── mensajes_moderar.php
│   │           ├── subject.php
│   │           └── subjects.php
│   ├── config/
│   │   └── app.php              # Configuración general (rutas, constantes)
│   ├── data/                    # Almacenamiento de datos (JSON)
│   │   ├── mensajes.json
│   │   ├── subjects.json
│   │   └── users.json
│   └── public/
│       ├── index.php            # Front controller y punto de entrada
│       ├── .htaccess            # Reescritura de URLs
│       └── recursos/
│           ├── estilos.css
│           ├── fuentes/
│           ├── iconos/
│           ├── imagenes/
│           └── js/
│               └── modo_oscuro.js
└── README.md
```

##  Rutas disponibles

### Autenticación

| Método | Ruta | Descripción | Autenticación |
|--------|------|-------------|----------------|
| GET | `/login` | Formulario de inicio de sesión | No |
| POST | `/login` | Procesar inicio de sesión | No |
| GET | `/register` | Formulario de registro | No |
| POST | `/register` | Procesar registro | No |
| POST | `/logout` | Cerrar sesión | Sí |

### Contenido principal

| Método | Ruta | Descripción | Autenticación |
|--------|------|-------------|----------------|
| GET | `/` | Página principal (listado de mensajes publicados) | Sí |
| GET | `/subjects` | Listado de todas las asignaturas | Sí |
| GET | `/subjects/{id}` | Mensajes de una asignatura específica | Sí |

### Mensajes

| Método | Ruta | Descripción | Autenticación | Rol |
|--------|------|-------------|----------------|-----|
| GET | `/messages/new` | Formulario para crear nuevo mensaje | Sí | Todos |
| POST | `/messages` | Publicar nuevo mensaje | Sí | Todos |

### Moderación

| Método | Ruta | Descripción | Autenticación | Rol |
|--------|------|-------------|----------------|-----|
| GET | `/moderation` | Cola de mensajes pendientes de moderación | Sí | Profesor |
| POST | `/moderation/{id}/approve` | Aprobar mensaje pendiente | Sí | Profesor |
| POST | `/moderation/{id}/reject` | Rechazar mensaje pendiente | Sí | Profesor |

##  Roles y permisos

### Alumno
-  Crear mensajes (1-280 caracteres)
-  Ver todos los mensajes publicados
-  Ver asignaturas y sus mensajes
-  Cambiar preferencia de tema (claro/oscuro)
-  No tiene acceso a moderación

### Profesor
-  Todas las funciones de alumno
-  Acceso a panel de moderación
-  Aprobar/rechazar mensajes pendientes
-  Ver cola de moderación

##  Validación y seguridad

### Validación de entrada

#### Usuario
- **Nombre de usuario**: Mínimo 3 caracteres, máximo 50, solo alfanuméricos y guiones
- **Email**: Formato de email válido
- **Contraseña**: Mínimo 8 caracteres, debe incluir mayúscula, minúscula y número
- **Rol**: Solo "alumno" o "profesor"

#### Mensajes
- **Longitud**: Entre 1 y 280 caracteres
- **Contenido**: Se escapa con `htmlspecialchars()` antes de mostrar
- **Patrones vetados**: Se bloquean automáticamente
  - `<script`
  - `onerror=`
  - `drop table`

### Medidas de seguridad

- **Hashing de contraseñas**: `password_hash()` con algoritmo BCRYPT
- **Verificación de contraseñas**: `password_verify()` para comparación segura
- **Cookies seguras**: 
  - `HttpOnly`: Previene acceso desde JavaScript
  - `SameSite=Lax`: Protege contra ataques CSRF
- **Rotación de ID de sesión**: Tras login exitoso con `session_regenerate_id(true)`
- **Autorización por rol**: Validación de permisos en rutas protegidas
- **Escapado de contenido**: `htmlspecialchars()` al renderizar datos del usuario
- **Mensajes genéricos**: En errores de autenticación para no revelar información

##  Funcionalidades principales

### Flujo de registro
1. Usuario accede a `/register`
2. Completa formulario con: nombre, email, contraseña, rol
3. Sistema valida todos los datos
4. Si hay errores, muestra avisos
5. Si es válido, hasheada contraseña y guarda usuario
6. Usuario queda logueado automáticamente
7. Redirección a página principal

### Flujo de inicio de sesión
1. Usuario accede a `/login`
2. Completa formulario con usuario y contraseña
3. Sistema verifica credenciales
4. Si son válidas:
   - Se establece sesión
   - Se regenera ID de sesión
   - Se redirige a la página solicitada (o inicio si no hay)
5. Si son inválidas, muestra aviso genérico

### Flujo de publicación de mensaje
1. Usuario logueado accede a `/messages/new`
2. Selecciona asignatura y escribe mensaje (máx 280 caracteres)
3. Sistema valida contenido
4. Si contiene patrones vetados → Estado: PENDIENTE (requiere moderación)
5. Si es válido → Estado: PUBLICADO (visible inmediatamente)
6. Mensaje se guarda en la base de datos JSON
7. Usuario recibe confirmación

### Flujo de moderación
1. Profesor accede a `/moderation`
2. Ve lista de mensajes pendientes
3. Para cada mensaje puede:
   - **Aprobar**: Cambia estado a PUBLICADO, mensaje visible para todos
   - **Rechazar**: Cambia estado a RECHAZADO, no es visible
4. Cola se actualiza en tiempo real

### Preferencia de tema
1. Usuario selecciona tema claro u oscuro
2. Preferencia se guarda en cookie
3. Al recargar la página, tema se aplica automáticamente
4. Ajustes persisten entre sesiones

##  Almacenamiento de datos

La aplicación utiliza archivos JSON para persistencia:
