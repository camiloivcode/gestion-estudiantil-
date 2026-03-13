<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-sm-flex align-items-center mb-4">
                <div>
                    <h4 class="font-weight-bold mb-0">Asistencia</h4>
                    <p class="text-secondary text-sm mb-0">Control de asistencia diaria</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('education.attendance.create') }}" class="btn btn-dark btn-sm mb-0">
                        <i class="fas fa-plus me-2"></i>Registrar Asistencia
                    </a>
                </div>
            </div>

            {{-- Resumen hoy --}}
            <div class="row mb-4">
                @foreach([
                    ['label'=>'% Asistencia Hoy','value'=>$avgPct.'%','color'=>'success'],
                    ['label'=>'Presentes','value'=>$presentToday,'color'=>'dark'],
                    ['label'=>'Ausentes','value'=>$absentToday,'color'=>'danger'],
                    ['label'=>'Justificados','value'=>$justToday,'color'=>'warning'],
                ] as $s)
                <div class="col-6 col-md-3 mb-2">
                    <div class="card border shadow-xs text-center p-3">
                        <h5 class="font-weight-bold mb-0 text-{{ $s['color'] }}">{{ $s['value'] }}</h5>
                        <p class="text-xs text-secondary mb-0">{{ $s['label'] }}</p>
                    </div>
                </div>
                @endforeach
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
                            <label class="form-label text-xs text-secondary mb-1">Fecha</label>
                            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-xs text-secondary mb-1">Estado</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <option value="present"   {{ request('status') === 'present'   ? 'selected' : '' }}>Presente</option>
                                <option value="absent"    {{ request('status') === 'absent'    ? 'selected' : '' }}>Ausente</option>
                                <option value="justified" {{ request('status') === 'justified' ? 'selected' : '' }}>Justificado</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-sm btn-dark w-100">Filtrar</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('education.attendance.index') }}" class="btn btn-sm btn-outline-secondary w-100">Limpiar</a>
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
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Estudiante</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Curso</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Fecha</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $att)
                                <tr>
                                    <td class="ps-3">
                                        <p class="text-sm font-weight-bold mb-0">{{ $att->student->name }}</p>
                                    </td>
                                    <td><p class="text-sm mb-0">{{ $att->course->name }}</p></td>
                                    <td class="text-center"><p class="text-sm mb-0">{{ $att->date->format('d/m/Y') }}</p></td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $att->status === 'present' ? 'success' : ($att->status === 'justified' ? 'warning' : 'danger') }}">
                                            {{ ['present'=>'Presente','absent'=>'Ausente','justified'=>'Justificado'][$att->status] }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('education.attendance.edit', $att) }}" class="btn btn-sm btn-outline-secondary mb-0 me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('education.attendance.destroy', $att) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Eliminar este registro?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger mb-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-secondary">No hay registros de asistencia.</td></tr>
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
