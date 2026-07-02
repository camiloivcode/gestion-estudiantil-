# AGENTS.md

## Project
**EduPlatform** — Laravel 11 student management system. Docker-based dev environment.

## Quick start
```bash
make fresh        # build + migrate + seed (first time, includes phpMyAdmin + Redis)
make up           # start all containers (with profile dev)
make up-min       # start only app/nginx/mysql (no phpMyAdmin)
make shell        # open bash in app container
make logs         # tail app + nginx logs
make clear        # clear Laravel caches
```

App: `http://localhost:8000` · phpMyAdmin: `http://localhost:8080` · Redis: `localhost:6379`

## Test accounts
| Role      | Email             | Password    |
|-----------|-------------------|-------------|
| Admin     | admin@edu.com     | password123 |
| Teacher   | garcia@edu.com    | password123 |
| Student   | ana@edu.com       | password123 |

## Architecture
- **Models** in `App\Models\` (User) and `App\Models\Education\` (Student, Teacher, Course, Grade, Attendance, Program)
- **Controllers** in `App\Http\Controllers\Education\*`
- **Routes** in `routes/web.php` — `/education/*` prefix, all auth-required
- **Custom role middleware**: `middleware('role:admin,teacher')` — registered as `'role'` alias in Kernel
- **Security headers middleware**: `SecurityHeadersMiddleware` in web group (CSP, HSTS, X-Frame-Options)
- **Custom helpers** in `bootstrap/helpers.php`: `is_current_route()`, `in_array_r()`, `getCategoriesArray()`
- **DB**: MySQL 8.0 on host port 3307, database `eduplatform`
- **Frontend**: Vite via `laravel-vite-plugin` — input at `resources/css/app.css` + `resources/js/app.js`

## Commands (run inside `make shell`)
```bash
php artisan migrate              # run migrations
php artisan migrate:fresh --seed # reset + seed
php artisan db:seed              # re-run seeders
./vendor/bin/phpunit             # run tests
./vendor/bin/pint                # lint (PSR-12)
```

## Key conventions
- `role` column on `users` table: `admin`, `teacher`, `student`
- `Route::resource` used for CRUD where possible; manual routes for grades (mixed permissions)
- `AttendanceController` and `StudentController` are misspelled (missing capital C) — **do not "fix"** to avoid route/class resolution breakage
- Login is rate-limited: `throttle:5,1` (5 attempts per minute)
- Delete modals use shared component `<x-app.delete-modal />` + `btn-delete` class
- PHP files: 4-space indentation, LF line endings

## Testing notes
- PHPUnit config at `phpunit.xml` — DB driver set to `array` cache, SQLite DB commented out (uses MySQL by default)
- `RefreshDatabase` trait is **not** imported in tests — tests run against the real DB unless changed
- `CreatesApplication` trait in `tests/`
- Education model factories in `database/factories/Education/`
- Tests in `tests/Feature/Auth/` and `tests/Feature/Education/`

## Deploy
- `docker-compose.prod.yml` for production with Redis + queue worker
- Docker entrypoint (`docker-entrypoint.sh`): auto-generates APP_KEY, runs migrations, caches config
- Healthcheck: `GET /health`
- Logging to stdout (cloud-friendly)
- See `DEPLOY.md` for platform-specific guides

## Recent improvements
- **Deploy**: entrypoint script, healthcheck route, Sentry config, custom error pages (403/404/500), `DEPLOY.md`, production docker-compose with queue worker, Redis-first drivers
- **Tests**: functional tests for Auth + all Education CRUDs, 6 model factories
- **Bloqueantes**: fixed missing `grade_4` column in migration, removed broken `Role` import in RegisterController, Dockerfile now uses `php-fpm` (not `artisan serve`), course routes now behind role middleware
- **Seguridad**: login rate limiting, CORS limited to `APP_URL`, session secure cookie config, password min 8 + complexity, Employee `$fillable`, security headers middleware
- **Docker**: multi-stage build with layer caching, `USER www-data`, healthchecks, resource limits, Nginx gzip/cache/security headers, Redis service, phpMyAdmin under `dev` profile, proper `mysqladmin ping` wait
- **Backend**: Dashboard N+1 optimized, bulk validation + transactions in Grade/Attendance, UserController pagination
- **Frontend**: shared delete modal component, fixed asset paths, Chart.js loaded once, fixed duplicate IDs in reset-password, `app.css` now loaded via Vite
