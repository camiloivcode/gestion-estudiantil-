<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-sm-flex align-items-center mb-4">
                <div><h4 class="font-weight-bold mb-0">Docentes</h4><p class="text-secondary text-sm mb-0">Gestión del cuerpo docente</p></div>
                <div class="ms-auto">
                    <a href="{{ route('education.teachers.create') }}" class="btn btn-dark btn-sm mb-0"><i class="fas fa-plus me-2"></i>Nuevo Docente</a>
                </div>
            </div>
            @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            <div class="card shadow-xs border">
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead><tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Docente</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Especialidad</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Cursos</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr></thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-sm font-weight-bold mb-0">{{ $teacher->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $teacher->email }}</p>
                                    </td>
                                    <td><p class="text-sm mb-0">{{ $teacher->specialty ?? '—' }}</p></td>
                                    <td class="text-center"><p class="text-sm mb-0">{{ $teacher->courses_count }}</p></td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $teacher->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ $teacher->status === 'active' ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('education.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary mb-0 me-1"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('education.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar {{ $teacher->name }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger mb-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-secondary">No hay docentes registrados.</td></tr>
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
