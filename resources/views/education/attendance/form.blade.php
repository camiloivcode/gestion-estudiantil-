<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" style="background:#f5f7fb;">
    <x-app.navbar />

    <div class="px-4 py-4 container-fluid">

        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('education.attendance.index') }}" 
                   class="btn btn-light btn-sm me-3 shadow-sm" 
                   style="border-radius:10px;">
                    ← Volver
                </a>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">
                        {{ isset($attendance) ? 'Editar Asistencia' : 'Registrar Asistencia' }}
                    </h4>
                    <small class="text-muted">Registra la asistencia de un estudiante</small>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm" style="border-radius:18px;">
                    <div class="card-body p-4">

                        @if($errors->any())
                            <div class="alert alert-danger border-0" style="border-radius:12px;">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $e)
                                        <li class="text-sm">{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ isset($attendance) ? route('education.attendance.update', $attendance) : route('education.attendance.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($attendance)) @method('PUT') @endif

                            @unless(isset($attendance))

                            <!-- Selects -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Estudiante</label>
                                <select name="student_id" class="form-control custom-input" required>
                                    <option value="">Seleccionar estudiante</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Curso</label>
                                <select name="course_id" class="form-control custom-input" required>
                                    <option value="">Seleccionar curso</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Fecha</label>
                                <input type="date" name="date" 
                                       class="form-control custom-input"
                                       value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>

                            @else
                            <div class="p-3 mb-3" style="background:#f1f5f9;border-radius:12px;">
                                <p class="mb-1"><strong>Estudiante:</strong> {{ $attendance->student->name }}</p>
                                <p class="mb-1"><strong>Curso:</strong> {{ $attendance->course->name }}</p>
                                <p class="mb-0"><strong>Fecha:</strong> {{ $attendance->date->format('d/m/Y') }}</p>
                            </div>
                            @endunless

                            <!-- Estado -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Estado</label>

                                <div class="d-flex gap-2">
                                    @foreach([
                                        'present'=>['#22c55e','Presente'],
                                        'absent'=>['#ef4444','Ausente'],
                                        'justified'=>['#3b82f6','Justificado']
                                    ] as $val => [$color,$label])

                                    <input type="radio" class="btn-check" name="status" id="st-{{ $val }}"
                                        value="{{ $val }}"
                                        {{ old('status', $attendance->status ?? 'present') === $val ? 'checked' : '' }}>

                                    <label for="st-{{ $val }}" 
                                           class="flex-fill text-center py-2"
                                           style="
                                               border:1px solid #e5e7eb;
                                               border-radius:12px;
                                               cursor:pointer;
                                               transition:0.2s;
                                           "
                                           onmouseover="this.style.background='{{ $color }}20'"
                                           onmouseout="this.style.background='transparent'">
                                        <span style="color:{{ $color }}; font-weight:600;">
                                            {{ $label }}
                                        </span>
                                    </label>

                                    @endforeach
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Observaciones</label>
                                <textarea name="notes" 
                                          class="form-control custom-input"
                                          rows="2"
                                          placeholder="Opcional...">{{ old('notes', $attendance->notes ?? '') }}</textarea>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('education.attendance.index') }}" 
                                   class="btn btn-light px-4"
                                   style="border-radius:10px;">
                                   Cancelar
                                </a>

                                <button type="submit" 
                                        class="btn text-white px-4"
                                        style="background:#1e293b; border-radius:10px;">
                                    {{ isset($attendance) ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-app.footer />
</main>

<style>
/* Inputs estilo dashboard */
.custom-input {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 10px;
    font-size: 14px;
}

.custom-input:focus {
    border-color: #1e293b;
    box-shadow: 0 0 0 2px rgba(30,41,59,0.1);
}
</style>

</x-app-layout>