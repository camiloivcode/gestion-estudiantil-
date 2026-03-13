<x-app-layout>

<div class="container py-4">

<h2>Edit Employee</h2>

<form action="{{ route('employees.update',$employee->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" value="{{ $employee->name }}" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="{{ $employee->email }}" class="form-control">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" value="{{ $employee->phone }}" class="form-control">
</div>

<div class="mb-3">
<label>Position</label>
<input type="text" name="position" value="{{ $employee->position }}" class="form-control">
</div>

<button class="btn btn-primary">
Update
</button>

</form>

</div>

</x-app-layout>
