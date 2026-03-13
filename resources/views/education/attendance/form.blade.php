<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.attendance.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                <h4 class="font-weight-bold mb-0">{{ isset($attendance) ? 'Editar Asistencia' : 'Registrar Asistencia' }}</h4>
            </div>
            <div class="row justify-content-center"><div class="col-lg-6">
                <div class="card shadow-xs border"><div class="card-body p-4">
                    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
                    <form action="{{ isset($attendance) ? route('education.attendance.update', $attendance) : route('education.attendance.store') }}" method="POST">
                        @csrf @if(isset($attendance)) @method('PUT') @endif
                        @if(!isset($attendance))
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Estudiante <span class="text-danger">*</span></label>
                            <select name="student_id" class="form-control" required>
                                <option value="">— Seleccionar —</option>
                                @foreach($students as $s)<option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Curso <span class="text-danger">*</span></label>
                            <select name="course_id" class="form-control" required>
                                <option value="">— Seleccionar —</option>
                                @foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>
                        @else
                        <div class="alert alert-light border mb-3"><strong>{{ $attendance->student->name }}</strong> — {{ $attendance->course->name }} — {{ $attendance->date->format('d/m/Y') }}</div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="present"   {{ old('status', $attendance->status ?? 'present') === 'present'   ? 'selected' : '' }}>Presente</option>
                                <option value="absent"    {{ old('status', $attendance->status ?? '') === 'absent'    ? 'selected' : '' }}>Ausente</option>
                                <option value="justified" {{ old('status', $attendance->status ?? '') === 'justified' ? 'selected' : '' }}>Justificado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Observaciones</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $attendance->notes ?? '') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('education.attendance.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-dark">{{ isset($attendance) ? 'Actualizar' : 'Guardar' }}</button>
                        </div>
                    </form>
                </div></div>
            </div></div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
