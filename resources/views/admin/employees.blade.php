@extends('layouts.admin')

@section('title', 'Employees')

@section('content')

  <h1 class="h3 mb-2 text-gray-800">Employees</h1>
  <p class="mb-4">Manage employee information here.</p>

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
      <a class="btn btn-primary btn-sm" id="addEmployeeBtn" href="/admin/employees/add">Add New Employee</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="employeesTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($employees as $employee)
            <tr>
              <td>{{ $employee->employee_id }}</td>
              <td>{{ $employee->employee_first_name }} {{ $employee->employee_middle_name }} {{ $employee->employee_last_name }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ $employee->phone }}</td>
              <td>{{ ucfirst($employee->role) }}</td>
              <td>
                <a class="btn btn-primary btn-sm view-employee" data-id="{{ $employee->employee_id }}" href="/admin/employees/{{$employee->employee_id }}/edit">
                  View
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>



@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#employeesTable').DataTable();
  });
</script>
@endsection
