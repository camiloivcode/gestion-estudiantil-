<x-app-layout>

<div class="container-fluid py-4">

<div class="row justify-content-center"> <!-- cambiado: se centra la fila para evitar solapamiento con la navbar -->
<div class="col-md-6 mx-auto"> <!-- cambiado: centra la columna -->

<div class="card">

<div class="card-header pb-0">
<h6>Create Employee</h6>
</div>

<div class="card-body">

<form action="{{ route('employees.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="mb-3">
<label>Position</label>
<input type="text" name="position" class="form-control">
</div>

<button class="btn btn-primary">
Save Employee
</button>

<a href="/employees" class="btn btn-secondary">
Back
</a>

</form>

</div>

</div>

</div>
</div>

</div>

</x-app-layout>
