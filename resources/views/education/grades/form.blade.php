<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.grades.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
                <h4 class="font-weight-bold mb-0">{{ isset($grade) ? 'Editar Calificación' : 'Registrar Calificación' }}</h4>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-xs border">
                        <div class="card-body p-4">
                            @if($errors->any())
                                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                            @endif
                            <form action="{{ isset($grade) ? route('education.grades.update', $grade) : route('education.grades.store') }}" method="POST">
                                @csrf
                                @if(isset($grade)) @method('PUT') @endif
                                <div class="row">
                                    @if(!isset($grade))
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Estudiante <span class="text-danger">*</span></label>
                                        <select name="student_id" class="form-control" required>
                                            <option value="">— Seleccionar —</option>
                                            @foreach($students as $s)
                                                <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Curso <span class="text-danger">*</span></label>
                                        <select name="course_id" class="form-control" required>
                                            <option value="">— Seleccionar —</option>
                                            @foreach($courses as $c)
                                                <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Periodo <span class="text-danger">*</span></label>
                                        <input type="text" name="period" class="form-control" placeholder="Ej: 2024-1" value="{{ old('period') }}" required>
                                    </div>
                                    @else
                                    <div class="col-12 mb-3">
                                        <div class="alert alert-light border">
                                            <strong>{{ $grade->student->name }}</strong> — {{ $grade->course->name }} — Periodo: {{ $grade->period }}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nota 1</label>
                                        <input type="number" name="grade_1" class="form-control" min="0" max="10" step="0.1"
                                            value="{{ old('grade_1', $grade->grade_1 ?? '') }}" placeholder="0.0 – 10.0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nota 2</label>
                                        <input type="number" name="grade_2" class="form-control" min="0" max="10" step="0.1"
                                            value="{{ old('grade_2', $grade->grade_2 ?? '') }}" placeholder="0.0 – 10.0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nota 3</label>
                                        <input type="number" name="grade_3" class="form-control" min="0" max="10" step="0.1"
                                            value="{{ old('grade_3', $grade->grade_3 ?? '') }}" placeholder="0.0 – 10.0">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Observaciones</label>
                                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $grade->notes ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('education.grades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-dark">{{ isset($grade) ? 'Actualizar' : 'Guardar' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
