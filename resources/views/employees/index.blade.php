<x-app-layout>

<div class="container-fluid py-4">

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-header pb-0 d-flex justify-content-between">
<h6>Employees</h6>

<a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
Add Employee
</a>

</div>

<div class="card-body px-0 pt-0 pb-2">

<div class="table-responsive p-0">

<table class="table align-items-center mb-0">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Position</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($employees as $employee)

<tr>
<td>{{ $employee->id }}</td>
<td>{{ $employee->name }}</td>
<td>{{ $employee->email }}</td>
<td>{{ $employee->phone }}</td>
<td>{{ $employee->position }}</td>

<td>

<a href="{{ route('employees.edit',$employee->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('employees.destroy',$employee->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>
</div>

</div>
</div>

</div>

</x-app-layout>
