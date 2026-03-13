<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.programs.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                <h4 class="font-weight-bold mb-0">{{ isset($program) ? 'Editar Programa' : 'Nuevo Programa' }}</h4>
            </div>
            <div class="row justify-content-center"><div class="col-lg-6">
                <div class="card shadow-xs border"><div class="card-body p-4">
                    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
                    <form action="{{ isset($program) ? route('education.programs.update', $program) : route('education.programs.store') }}" method="POST">
                        @csrf @if(isset($program)) @method('PUT') @endif
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label text-sm font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $program->name ?? '') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-sm font-weight-bold">Código</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $program->code ?? '') }}" placeholder="Ej: ISI">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-sm font-weight-bold">Duración (semestres) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_semesters" class="form-control" min="1" max="16" value="{{ old('duration_semesters', $program->duration_semesters ?? 8) }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label text-sm font-weight-bold">Descripción</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $program->description ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('education.programs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-dark">{{ isset($program) ? 'Actualizar' : 'Guardar' }}</button>
                        </div>
                    </form>
                </div></div>
            </div></div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
