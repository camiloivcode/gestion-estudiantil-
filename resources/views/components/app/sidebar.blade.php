<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('education.dashboard') }}">
            <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="white">
                <path d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z"/>
                <path d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z"/>
            </svg>
            <span class="font-weight-bold text-lg text-white">EduPlatform</span>
        </a>
    </div>

    <div class="collapse navbar-collapse px-4 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ is_current_route('education.dashboard') ? 'active' : '' }}"
                    href="{{ route('education.dashboard') }}">
                    <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="28px" height="28px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#FFFFFF" fill-rule="nonzero">
                                <path class="color-foreground" d="M0,1.71428571 C0,0.76752 0.76752,0 1.71428571,0 L22.2857143,0 C23.2325143,0 24,0.76752 24,1.71428571 L24,5.14285714 C24,6.08962286 23.2325143,6.85714286 22.2857143,6.85714286 L1.71428571,6.85714286 C0.76752,6.85714286 0,6.08962286 0,5.14285714 L0,1.71428571 Z"/>
                                <path class="color-background" d="M0,12 C0,11.0532171 0.76752,10.2857143 1.71428571,10.2857143 L12,10.2857143 C12.9468,10.2857143 13.7142857,11.0532171 13.7142857,12 L13.7142857,22.2857143 C13.7142857,23.2325143 12.9468,24 12,24 L1.71428571,24 C0.76752,24 0,23.2325143 0,22.2857143 L0,12 Z"/>
                                <path class="color-background" d="M18.8571429,10.2857143 C17.9103429,10.2857143 17.1428571,11.0532171 17.1428571,12 L17.1428571,22.2857143 C17.1428571,23.2325143 17.9103429,24 18.8571429,24 L22.2857143,24 C23.2325143,24 24,23.2325143 24,22.2857143 L24,12 C24,11.0532171 23.2325143,10.2857143 22.2857143,10.2857143 L18.8571429,10.2857143 Z"/>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- ── ACADÉMICO ────────────────────────────────────────────── --}}
            <li class="nav-item mt-3">
                <div class="d-flex align-items-center nav-link ps-1">
                    <span class="text-white opacity-6 font-weight-normal text-xs ms-1 text-uppercase letter-spacing-1">Académico</span>
                </div>
            </li>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.students.*') ? 'active' : '' }}"
                    href="{{ route('education.students.index') }}">
                    <span class="nav-link-text ms-1">Estudiantes</span>
                </a>
            </li>
            @endif

            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.courses.*') ? 'active' : '' }}"
                    href="{{ route('education.courses.index') }}">
                    <span class="nav-link-text ms-1">Cursos</span>
                </a>
            </li>

            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.grades.*') ? 'active' : '' }}"
                    href="{{ route('education.grades.index') }}">
                    <span class="nav-link-text ms-1">Calificaciones</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.attendance.*') ? 'active' : '' }}"
                    href="{{ route('education.attendance.index') }}">
                    <span class="nav-link-text ms-1">Asistencia</span>
                </a>
            </li>
            @endif

            {{-- ── ADMINISTRACIÓN (solo admin) ──────────────────────────── --}}
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <div class="d-flex align-items-center nav-link ps-1">
                    <span class="text-white opacity-6 font-weight-normal text-xs ms-1 text-uppercase letter-spacing-1">Administración</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.teachers.*') ? 'active' : '' }}"
                    href="{{ route('education.teachers.index') }}">
                    <span class="nav-link-text ms-1">Docentes</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.programs.*') ? 'active' : '' }}"
                    href="{{ route('education.programs.index') }}">
                    <span class="nav-link-text ms-1">Programas</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management') ? 'active' : '' }}"
                    href="{{ route('users-management') }}">
                    <span class="nav-link-text ms-1">Usuarios del Sistema</span>
                </a>
            </li>
            @endif

            {{-- ── MI CUENTA ────────────────────────────────────────────── --}}
            <li class="nav-item mt-3">
                <div class="d-flex align-items-center nav-link ps-1">
                    <span class="text-white opacity-6 font-weight-normal text-xs ms-1 text-uppercase letter-spacing-1">Mi Cuenta</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users.profile') ? 'active' : '' }}"
                    href="{{ route('users.profile') }}">
                    <span class="nav-link-text ms-1">Mi Perfil</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="nav-link position-relative ms-0 ps-2 py-2 bg-transparent border-0 w-100 text-start"
                        style="cursor:pointer;">
                        <span class="nav-link-text ms-1" style="color:#f87171;">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                        </span>
                    </button>
                </form>
            </li>

        </ul>
    </div>

    {{-- User badge --}}
    <div class="sidenav-footer mx-4">
        <div class="card border-radius-md" id="sidenavCard">
            <div class="card-body p-3 w-100">
                <div class="d-flex align-items-center">
                    <div class="me-2 text-white d-flex align-items-center justify-content-center fw-bold"
                        style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.2);font-size:13px;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div style="min-width:0">
                        <p class="mb-0 text-white text-sm font-weight-bold text-truncate">{{ auth()->user()->name }}</p>
                        <span class="badge bg-{{ auth()->user()->isAdmin() ? 'danger' : (auth()->user()->isTeacher() ? 'warning' : 'success') }} text-white"
                            style="font-size:9px;">
                            {{ auth()->user()->role_label }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
