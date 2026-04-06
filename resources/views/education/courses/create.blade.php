<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" style="background:#f5f7fb;">
    <x-app.navbar />

    <div class="container-fluid py-4">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.courses.index') }}" class="btn btn-light btn-sm me-3">← Volver</a>
            <div>
                <h4 class="fw-bold mb-0">Nuevo Curso</h4>
                <small class="text-muted">Crear un nuevo curso</small>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="border-radius:16px;">
                    <div class="card-body p-4">

                        <form action="{{ route('education.courses.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="name" class="form-control custom-input" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Código</label>
                                    <input type="text" name="code" class="form-control custom-input">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Docente</label>
                                    <select name="teacher_id" class="form-control custom-input">
                                        <option value="">Sin asignar</option>
                                        @foreach($teachers as $t)
                                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Programa</label>
                                    <select name="program_id" class="form-control custom-input">
                                        <option value="">Sin programa</option>
                                        @foreach($programs as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Créditos</label>
                                    <select name="credits" class="form-control custom-input">
                                        @for($i=1;$i<=10;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado</label>
                                    <select name="status" class="form-control custom-input">
                                        <option value="active">Activo</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="finished">Finalizado</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="description" class="form-control custom-input"></textarea>
                                </div>

                            </div>

                            <div class="text-end">
                                <button class="btn text-white px-4" style="background:#1e293b; border-radius:10px;">
                                    Guardar
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

<style>
.custom-input {
    border-radius:10px;
    border:1px solid #e5e7eb;
}
</style>

</x-app-layout>