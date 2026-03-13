<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">

            <div class="d-sm-flex align-items-center mb-4">
                <div>
                    <h4 class="font-weight-bold mb-0">Estudiantes</h4>
                    <p class="text-secondary text-sm mb-0">Gestión de estudiantes matriculados</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('education.students.create') }}" class="btn btn-dark btn-sm mb-0">
                        <i class="fas fa-plus me-2"></i>Nuevo Estudiante
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-xs border">
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="datatable-students">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Estudiante</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Semestre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Promedio</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
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
                                    <td><p class="text-sm mb-0">{{ $student->student_code ?? '—' }}</p></td>
                                    <td><p class="text-sm mb-0">{{ $student->program->name ?? '—' }}</p></td>
                                    <td class="text-center"><p class="text-sm mb-0">{{ $student->semester }}°</p></td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $student->status === 'active' ? 'success' : ($student->status === 'graduated' ? 'info' : 'secondary') }}">
                                            {{ ['active'=>'Activo','inactive'=>'Inactivo','graduated'=>'Graduado'][$student->status] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-sm font-weight-bold {{ $student->average >= 6 ? 'text-success' : ($student->average ? 'text-danger' : 'text-secondary') }}">
                                            {{ $student->average ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('education.students.edit', $student) }}"
                                            class="btn btn-sm btn-outline-secondary mb-0 me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('education.students.destroy', $student) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Eliminar estudiante {{ $student->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger mb-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-secondary">
                                        No hay estudiantes registrados.
                                        <a href="{{ route('education.students.create') }}">Crear el primero</a>
                                    </td>
                                </tr>
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
