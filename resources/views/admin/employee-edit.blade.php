@extends('layouts.admin')

@section('title', 'Add Employee')

@section('content')

   <div class="d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-2 text-gray-800">View/Edit Employee</h1>
      <a href="/admin/employees" class="btn btn-secondary">Go Back</a>
  </div>
  <p class="mb-4">Use this form to add a new employee to the system.</p>

    <x-employee-form :employee="$employee" />

@endsection