<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">

            {{-- Bienvenida --}}
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-xs p-3"
                        style="background:linear-gradient(135deg,#1e293b 0%,#334155 100%);border-radius:12px;">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="text-white font-weight-bold mb-1">Bienvenido, {{ auth()->user()->name }} 👋</h5>
                                <p class="text-white opacity-7 mb-0 text-sm">
                                    Rol: <strong>{{ auth()->user()->role_label }}</strong>
                                    &nbsp;·&nbsp; {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-body text-start p-3 w-100">
                            <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-user-graduate" style="font-size:14px;"></i>
                            </div>
                            <p class="text-sm text-secondary mb-1">Total Estudiantes</p>
                            <h4 class="mb-1 font-weight-bold">{{ number_format($totalStudents) }}</h4>
                            <a href="{{ route('education.students.index') }}" class="text-xs text-primary">Ver todos →</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-body text-start p-3 w-100">
                            <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-book-open" style="font-size:14px;"></i>
                            </div>
                            <p class="text-sm text-secondary mb-1">Cursos Activos</p>
                            <h4 class="mb-1 font-weight-bold">{{ number_format($activeCourses) }}</h4>
                            <a href="{{ route('education.courses.index') }}" class="text-xs text-primary">Ver todos →</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-body text-start p-3 w-100">
                            <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-chalkboard-teacher" style="font-size:14px;"></i>
                            </div>
                            <p class="text-sm text-secondary mb-1">Docentes</p>
                            <h4 class="mb-1 font-weight-bold">{{ number_format($totalTeachers) }}</h4>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('education.teachers.index') }}" class="text-xs text-primary">Ver todos →</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-body text-start p-3 w-100">
                            <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-chart-bar" style="font-size:14px;"></i>
                            </div>
                            <p class="text-sm text-secondary mb-1">Promedio General</p>
                            <h4 class="mb-1 font-weight-bold">{{ $avgGrade }}<span class="text-sm text-secondary">/10</span></h4>
                            <a href="{{ route('education.grades.index') }}" class="text-xs text-primary">Ver calificaciones →</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart + Actividad --}}
            <div class="row mt-2">
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-xs border">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Rendimiento Académico</h6>
                            <p class="text-sm mb-0 text-secondary">Promedio de calificaciones por curso</p>
                        </div>
                        <div class="card-body p-3">
                            <canvas id="chart-bars" class="chart-canvas" height="180"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Actividad Reciente</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-success"><i class="fas fa-check text-white text-xs"></i></span>
                                    <div class="timeline-content ms-3">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Matrícula aprobada</h6>
                                        <p class="text-secondary text-xs mb-0">Ana Torres – Matemáticas II</p>
                                        <small class="text-xs text-muted">hace 5 min</small>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-info"><i class="fas fa-book text-white text-xs"></i></span>
                                    <div class="timeline-content ms-3">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Nuevo curso creado</h6>
                                        <p class="text-secondary text-xs mb-0">Bases de Datos – Ing. Torres</p>
                                        <small class="text-xs text-muted">hace 1 hora</small>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-warning"><i class="fas fa-exclamation text-white text-xs"></i></span>
                                    <div class="timeline-content ms-3">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Nota pendiente</h6>
                                        <p class="text-secondary text-xs mb-0">Historia – 3er corte</p>
                                        <small class="text-xs text-muted">hace 2 horas</small>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-primary"><i class="fas fa-user-plus text-white text-xs"></i></span>
                                    <div class="timeline-content ms-3">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Nuevo estudiante</h6>
                                        <p class="text-secondary text-xs mb-0">Daniela Mora registrada</p>
                                        <small class="text-xs text-muted">hace 3 horas</small>
                                    </div>
                                </div>
                                <div class="timeline-block">
                                    <span class="timeline-step bg-danger"><i class="fas fa-times text-white text-xs"></i></span>
                                    <div class="timeline-content ms-3">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Inasistencia reportada</h6>
                                        <p class="text-secondary text-xs mb-0">Carlos Ruiz – Programación</p>
                                        <small class="text-xs text-muted">ayer</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla estudiantes recientes --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-xs border">
                        <div class="card-header pb-0">
                            <div class="d-sm-flex align-items-center mb-2">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Estudiantes Recientes</h6>
                                    <p class="text-sm mb-0 text-secondary">Últimos inscritos en el sistema</p>
                                </div>
                                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                <div class="ms-auto">
                                    <a href="{{ route('education.students.create') }}" class="btn btn-sm btn-dark mb-0 me-2">
                                        <i class="fas fa-plus me-1"></i>Nuevo
                                    </a>
                                    <a href="{{ route('education.students.index') }}" class="btn btn-sm btn-outline-dark mb-0">
                                        Ver todos
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Estudiante</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Semestre</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentStudents as $student)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 text-white d-flex align-items-center justify-content-center fw-bold"
                                                        style="width:34px;height:34px;border-radius:8px;background:#1e293b;font-size:12px;flex-shrink:0;">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-weight-bold mb-0">{{ $student->name }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $student->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><p class="text-sm mb-0">{{ $student->program->name ?? '—' }}</p></td>
                                            <td class="text-center"><p class="text-sm mb-0">{{ $student->semester }}°</p></td>
                                            <td class="text-center">
                                                <span class="badge badge-sm bg-gradient-{{ $student->status === 'active' ? 'success' : ($student->status === 'graduated' ? 'info' : 'secondary') }}">
                                                    {{ ['active'=>'Activo','inactive'=>'Inactivo','graduated'=>'Graduado'][$student->status] ?? $student->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-secondary">No hay estudiantes registrados aún.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <x-app.footer />
    </main>
</x-app-layout>
