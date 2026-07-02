# EduPlatform — Sistema de Gestión Estudiantil

Sistema de gestión académica construido con Laravel 11, Docker, MySQL y Redis.

## Requisitos

- [Docker](https://docs.docker.com/get-docker/) + [Docker Compose](https://docs.docker.com/compose/install/)
- Make (opcional, disponible en Linux/Mac; en Windows usar PowerShell/Git Bash)

## Inicio rápido

```bash
# Primera vez (build + migraciones + datos de prueba)
make fresh
```

Esto levanta todos los servicios y crea las tablas con datos de ejemplo.

Luego de la primera vez, solo usar:

```bash
make up       # Iniciar contenedores
make up-min   # Iniciar sin phpMyAdmin
make down     # Detener contenedores
```

## Cuentas de prueba

| Rol       | Correo             | Contraseña  |
|-----------|--------------------|-------------|
| Admin     | admin@edu.com      | password123 |
| Docente   | garcia@edu.com     | password123 |
| Estudiante| ana@edu.com        | password123 |

## URLs

| Servicio     | URL                          |
|--------------|------------------------------|
| App          | http://localhost:8000        |
| phpMyAdmin   | http://localhost:8080        |
| Redis        | localhost:6379               |

## Comandos disponibles

### Make (recomendado)

```bash
make fresh    # Build + migrate + seed (primera vez)
make up       # Iniciar todos los contenedores
make up-min   # Iniciar solo app/nginx/mysql
make down     # Detener contenedores
make build    # Reconstruir imágenes
make shell    # Terminal dentro del contenedor app
make logs     # Ver logs de app + nginx
make migrate  # Ejecutar migraciones
make seed     # Ejecutar seeders
make key      # Generar APP_KEY
make clear    # Limpiar cachés de Laravel
make ps       # Ver estado de contenedores
```

### Dentro del contenedor (`make shell`)

```bash
php artisan migrate              # Migrar base de datos
php artisan migrate:fresh --seed # Resetear y sembrar
php artisan db:seed              # Re-ejecutar seeders
./vendor/bin/phpunit             # Ejecutar tests
./vendor/bin/pint                # Formatear código (PSR-12)
```

## Variables de entorno

El archivo `.env.docker` contiene la configuración lista para Docker. Al ejecutar `make up` o `make fresh` se copia automáticamente a `.env`. Los valores por defecto son:

| Variable          | Valor               |
|-------------------|---------------------|
| DB_DATABASE       | eduplatform         |
| DB_USERNAME       | eduplatform         |
| DB_PASSWORD       | eduplatform         |
| DB_PORT (host)    | 3307                |
| APP_PORT          | 8000                |
| PMA_PORT          | 8080                |
| REDIS_PORT        | 6379                |

## Estructura del proyecto

```
├── app/
│   ├── Http/Controllers/Education/   # Controladores CRUD
│   ├── Models/                        # Modelos base (User)
│   └── Models/Education/             # Student, Teacher, Course, Grade, etc.
├── config/                            # Configuración de Laravel
├── database/
│   ├── factories/Education/           # Factories para tests
│   └── seeders/                       # Seeders con datos de prueba
├── docker/                            # Dockerfiles y configs de Nginx/PHP
├── resources/                         # Vistas, CSS, JS (Vite)
├── routes/web.php                     # Todas las rutas web
├── tests/                             # Tests funcionales
├── docker-compose.yml                 # Servicios Docker
├── Makefile                           # Comandos shortcuts
└── DEPLOY.md                          # Guía de producción
```

## Rutas principales

Todas bajo el prefijo `/education/*` — requieren autenticación.

- `/education/dashboard` — Panel principal
- `/education/students` — CRUD estudiantes
- `/education/teachers` — CRUD docentes
- `/education/courses` — CRUD cursos
- `/education/grades` — Calificaciones
- `/education/attendance` — Asistencia
- `/education/programs` — Programas académicos

## Roles y permisos

- **admin** — Acceso completo a todo el sistema
- **teacher** — Gestión de calificaciones y asistencia
- **student** — Visualización de notas y cursos

Los roles se asignan en la columna `role` de la tabla `users`. Middleware personalizado: `middleware('role:admin,teacher')`.

## Notas

- Login limitado a 5 intentos por minuto (`throttle:5,1`)
- phpMyAdmin solo se levanta con `make up` o `make fresh` (perfil `dev`)
- Para producción ver [`DEPLOY.md`](./DEPLOY.md)
