# P8 — Desarrollo (BC4): Red social interna mínima en PHP

### Objetivo

Desarrollar una red social interna mínima centrada en contenidos de BC4: sesiones, cookies, autenticación básica, validación, seguridad elemental y moderación sencilla. Sin BD, sin POO avanzada, sin frameworks, sin APIs.

### Alcance funcional

R1.- Registro e inicio de sesión
    R1.1.- Alta de usuario con nombre, email y contraseña hasheada (password_hash).
    R1.2.- Rol elegido al registrarse: alumno o profesor.
    R1.3.- Rotación de ID de sesión tras login (session_regenerate_id(true)).
R2.- Publicación de mensajes
    R2.1.- Crear mensajes 1–280 caracteres asociados a asignatura.
    R2.2.- Listado de mensajes publicados en portada.
R3.- Moderación
    R3.1.- Reglas simples de relevancia por asignatura y bloqueo de patrones peligrosos (<script, onerror=, drop table).
    R3.2.- Mensajes no válidos → estado pending. El profesor puede aprobar/rechazar.
R4.- Preferencias en cookies
    R4.1- Tema claro/oscuro guardado en cookie y aplicado en la interfaz.

### Límites SOLO‑BC4 (para no pisar BC5/BC6)

- Persistencia: sin base de datos. Usar sesión y/o ficheros JSON (users.json, messages.json).
- Arquitectura: MVC simple con scripts/funciones. Evitar POO avanzada y patrones.
- Vistas server‑rendered en PHP. Sin SPA ni frameworks JS.
- Sin integraciones ni APIs. Sin CI/CD.

### Requisitos técnicos

- PHP 8.1+
- Estructura mínima

```bash
/app
	/Controllers  # AuthController.php, MessageController.php, ModerationController.php
	/Models       # funciones de lectura/escritura sesión/JSON
	/Views        # login.php, register.php, home.php, new_message.php, moderation_queue.php
/public
	index.php     # front controller + router básico
/config
	app.php       # APP_ENV, rutas de datos, etc.
/data
	users.json (opcional)
	messages.json (opcional)
```

- Sesiones y cookies
    - session_set_cookie_params con HttpOnly y SameSite=Lax.
    - Rotación de ID tras login.
    - Co
    okie de tema.
- Validación y seguridad
    - Longitud 1–280. `htmlspecialchars` al mostrar contenido.
    - Bloqueo de patrones: <script, onerror=, drop table.
    - Autorización por rol en moderación.

### Rutas mínimas

- GET `/` — lista de mensajes publicados
- GET `/register` y POST `/register` — alta con rol
- GET `/login` y POST `/login` — autenticación
- POST `/logout` — cierre de sesión
- GET `/messages/new` y POST `/messages` — crear mensaje
- GET `/moderation` — cola pending (solo profesor)
- POST `/moderation/{id}/approve` y `/reject` — moderar

### Entregables P8

- Código funcional con estructura MVC simple.
- README.md breve con: arranque local, rutas y roles, validación y sanitización.

### Criterios de evaluación P8

- Implementación MVC — 25%
- Sesiones y autenticación — 20%
- Cookies y preferencias — 10%
- Validación y seguridad — 25%
- Calidad de código y documentación — 10%
- Smoke test básico (manual, local) — 10%

### Guía sugerida de trabajo

1) Esqueleto y router en index.php

2) Registro/login/logout con rotación de sesión

3) Publicación + listado (published|pending|rejected)

4) Moderación profesor (approve/reject)

5) Cookie de tema y aplicación en layout
