<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('education.teachers.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="fas fa-arrow-left me-1"></i> Volver</a>
                <h4 class="font-weight-bold mb-0">{{ isset($teacher) ? 'Editar Docente' : 'Nuevo Docente' }}</h4>
            </div>
            <div class="row justify-content-center"><div class="col-lg-6">
                <div class="card shadow-xs border"><div class="card-body p-4">
                    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
                    <form action="{{ isset($teacher) ? route('education.teachers.update', $teacher) : route('education.teachers.store') }}" method="POST">
                        @csrf @if(isset($teacher)) @method('PUT') @endif
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Correo <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Especialidad</label>
                            <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $teacher->specialty ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold">Estado</label>
                            <select name="status" class="form-control">
                                <option value="active"   {{ old('status', $teacher->status ?? 'active') === 'active'   ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ old('status', $teacher->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('education.teachers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-dark">{{ isset($teacher) ? 'Actualizar' : 'Guardar' }}</button>
                        </div>
                    </form>
                </div></div>
            </div></div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
