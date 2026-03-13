<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-sm-flex align-items-center mb-4">
                <div>
                    <h4 class="font-weight-bold mb-0">Calificaciones</h4>
                    <p class="text-secondary text-sm mb-0">Registro y seguimiento de notas</p>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                <div class="ms-auto">
                    <a href="{{ route('education.grades.create') }}" class="btn btn-dark btn-sm mb-0">
                        <i class="fas fa-plus me-2"></i>Registrar Nota
                    </a>
                </div>
                @endif
            </div>

            {{-- Filtros --}}
            <div class="card shadow-xs border mb-4">
                <div class="card-body p-3">
                    <form method="GET" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label text-xs text-secondary mb-1">Curso</label>
                            <select name="course_id" class="form-control form-control-sm">
                                <option value="">Todos los cursos</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-xs text-secondary mb-1">Estado</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobados (≥6)</option>
                                <option value="failed"   {{ request('status') === 'failed'   ? 'selected' : '' }}>Reprobados (&lt;6)</option>
                                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Sin notas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-dark w-100">Filtrar</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('education.grades.index') }}" class="btn btn-sm btn-outline-secondary w-100">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="card shadow-xs border">
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="datatable-grades">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Estudiante</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Curso</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Periodo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 1</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 2</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 3</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Promedio</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                    <th class="text-secondary opacity-7"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-sm font-weight-bold mb-0">{{ $grade->student->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $grade->student->student_code ?? '' }}</p>
                                    </td>
                                    <td><p class="text-sm mb-0">{{ $grade->course->name }}</p></td>
                                    <td class="text-center"><span class="badge bg-light text-dark">{{ $grade->period }}</span></td>
                                    <td class="text-center">{{ $grade->grade_1 ?? '—' }}</td>
                                    <td class="text-center">{{ $grade->grade_2 ?? '—' }}</td>
                                    <td class="text-center">{{ $grade->grade_3 ?? '—' }}</td>
                                    <td class="text-center">
                                        @if($grade->average !== null)
                                            <span class="font-weight-bold {{ $grade->average >= 6 ? 'text-success' : 'text-danger' }}">
                                                {{ $grade->average }}
                                            </span>
                                        @else
                                            <span class="text-secondary">—</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                    <td class="text-end pe-3">
                                        <a href="{{ route('education.grades.edit', $grade) }}" class="btn btn-sm btn-outline-secondary mb-0 me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('education.grades.destroy', $grade) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Eliminar esta calificación?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger mb-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="8" class="text-center py-5 text-secondary">No hay calificaciones registradas.</td></tr>
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
