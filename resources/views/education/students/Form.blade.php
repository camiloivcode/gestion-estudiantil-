<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">

            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.students.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
                <h4 class="font-weight-bold mb-0">
                    {{ isset($student) ? 'Editar Estudiante' : 'Nuevo Estudiante' }}
                </h4>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-xs border">
                        <div class="card-body p-4">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ isset($student) ? route('education.students.update', $student) : route('education.students.store') }}"
                                method="POST">
                                @csrf
                                @if(isset($student)) @method('PUT') @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nombre completo <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $student->name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $student->email ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Código estudiantil</label>
                                        <input type="text" name="student_code" class="form-control"
                                            value="{{ old('student_code', $student->student_code ?? '') }}"
                                            placeholder="Ej: 2024-001">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Programa</label>
                                        <select name="program_id" class="form-control">
                                            <option value="">— Sin programa —</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}"
                                                    {{ old('program_id', $student->program_id ?? '') == $program->id ? 'selected' : '' }}>
                                                    {{ $program->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Semestre <span class="text-danger">*</span></label>
                                        <select name="semester" class="form-control" required>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('semester', $student->semester ?? 1) == $i ? 'selected' : '' }}>
                                                    {{ $i }}° Semestre
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="active"    {{ old('status', $student->status ?? 'active') === 'active'    ? 'selected' : '' }}>Activo</option>
                                            <option value="inactive"  {{ old('status', $student->status ?? '') === 'inactive'  ? 'selected' : '' }}>Inactivo</option>
                                            <option value="graduated" {{ old('status', $student->status ?? '') === 'graduated' ? 'selected' : '' }}>Graduado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Fecha de matrícula</label>
                                        <input type="date" name="enrollment_date" class="form-control"
                                            value="{{ old('enrollment_date', isset($student) ? $student->enrollment_date?->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Notas / Observaciones</label>
                                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $student->notes ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('education.students.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-dark">
                                        {{ isset($student) ? 'Actualizar' : 'Guardar' }}
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
</x-app-layout>
