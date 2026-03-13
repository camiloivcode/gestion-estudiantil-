<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.courses.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
                <h4 class="font-weight-bold mb-0">{{ isset($course) ? 'Editar Curso' : 'Nuevo Curso' }}</h4>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-xs border">
                        <div class="card-body p-4">
                            @if($errors->any())
                                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                            @endif
                            <form action="{{ isset($course) ? route('education.courses.update', $course) : route('education.courses.store') }}" method="POST">
                                @csrf
                                @if(isset($course)) @method('PUT') @endif
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nombre del curso <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $course->name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Código</label>
                                        <input type="text" name="code" class="form-control" value="{{ old('code', $course->code ?? '') }}" placeholder="Ej: MAT-201">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Docente</label>
                                        <select name="teacher_id" class="form-control">
                                            <option value="">— Sin asignar —</option>
                                            @foreach($teachers as $t)
                                                <option value="{{ $t->id }}" {{ old('teacher_id', $course->teacher_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Programa</label>
                                        <select name="program_id" class="form-control">
                                            <option value="">— Sin programa —</option>
                                            @foreach($programs as $p)
                                                <option value="{{ $p->id }}" {{ old('program_id', $course->program_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Créditos <span class="text-danger">*</span></label>
                                        <input type="number" name="credits" class="form-control" min="1" max="10" value="{{ old('credits', $course->credits ?? 3) }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="active"   {{ old('status', $course->status ?? 'active') === 'active'   ? 'selected' : '' }}>Activo</option>
                                            <option value="pending"  {{ old('status', $course->status ?? '') === 'pending'  ? 'selected' : '' }}>Pendiente</option>
                                            <option value="finished" {{ old('status', $course->status ?? '') === 'finished' ? 'selected' : '' }}>Finalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-sm font-weight-bold">Descripción</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('education.courses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-dark">{{ isset($course) ? 'Actualizar' : 'Guardar' }}</button>
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
