<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">

            <div class="d-sm-flex align-items-center mb-4">
                <div>
                    <h4 class="font-weight-bold mb-0">Cursos</h4>
                    <p class="text-secondary text-sm mb-0">Gestión de cursos académicos</p>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                <div class="ms-auto">
                    <a href="{{ route('education.courses.create') }}" class="btn btn-dark btn-sm mb-0">
                        <i class="fas fa-plus me-2"></i>Nuevo Curso
                    </a>
                </div>
                @endif
            </div>

            {{-- Mini stats --}}
            <div class="row mb-4">
                @foreach([
                    ['label'=>'Total','value'=>$totalCourses,'color'=>'dark'],
                    ['label'=>'Activos','value'=>$activeCourses,'color'=>'success'],
                    ['label'=>'Pendientes','value'=>$pendingCourses,'color'=>'warning'],
                    ['label'=>'Finalizados','value'=>$finishedCourses,'color'=>'secondary'],
                ] as $stat)
                <div class="col-6 col-md-3 mb-2">
                    <div class="card border shadow-xs text-center p-3">
                        <h5 class="font-weight-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['value'] }}</h5>
                        <p class="text-xs text-secondary mb-0">{{ $stat['label'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-xs border">
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="datatable-courses">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Curso</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Docente</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Créditos</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Inscritos</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                    <th class="text-secondary opacity-7"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-sm font-weight-bold mb-0">{{ $course->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $course->code ?? '—' }}</p>
                                    </td>
                                    <td><p class="text-sm mb-0">{{ $course->teacher->name ?? '—' }}</p></td>
                                    <td><p class="text-sm mb-0">{{ $course->program->name ?? '—' }}</p></td>
                                    <td class="text-center"><p class="text-sm mb-0">{{ $course->credits }}</p></td>
                                    <td class="text-center"><p class="text-sm mb-0">{{ $course->students_count }}</p></td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $course->status === 'active' ? 'success' : ($course->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ['active'=>'Activo','pending'=>'Pendiente','finished'=>'Finalizado'][$course->status] }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                    <td class="text-end pe-3">
                                        <a href="{{ route('education.courses.edit', $course) }}"
                                            class="btn btn-sm btn-outline-secondary mb-0 me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('education.courses.destroy', $course) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('¿Eliminar {{ $course->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger mb-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-5 text-secondary">No hay cursos registrados.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
