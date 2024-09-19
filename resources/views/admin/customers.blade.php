@extends('layouts.admin')

@section('title', 'Customers')

@section('content')

  <h1 class="h3 mb-2 text-gray-800">Customers</h1>
  <p class="mb-4">Manage customer information here.</p>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="customersTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Gender</th>
              <th>Birthday</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($customers as $customer)
            <tr>
              <td>{{ $customer->user_id }}</td>
              <td>{{ $customer->first_name }} {{ $customer->middle_name }} {{ $customer->last_name }}</td>
              <td>{{ $customer->email }}</td>
              <td>{{ $customer->phone }}</td>
              <td>{{ ucfirst($customer->gender) }}</td>
              <td>{{ \Carbon\Carbon::parse($customer->birthday)->format('Y-m-d') }}</td>
              <td>
                <a class="btn btn-primary btn-sm edit-customer" data-id="{{ $customer->user_id }}" href="/admin/customers/{{ $customer->user_id }}">
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


<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" role="dialog" aria-labelledby="viewCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewCustomerModalLabel">Customer Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="viewCustomerDetails">
        <!-- Customer details will be populated here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editCustomerForm">
          @csrf
          @method('PUT')
          <input type="hidden" id="editCustomerId" name="user_id">
          <div class="form-group">
            <label for="editFirstName">First Name</label>
            <input type="text" class="form-control" id="editFirstName" name="first_name" required>
          </div>
          <div class="form-group">
            <label for="editMiddleName">Middle Name</label>
            <input type="text" class="form-control" id="editMiddleName" name="middle_name">
          </div>
          <div class="form-group">
            <label for="editLastName">Last Name</label>
            <input type="text" class="form-control" id="editLastName" name="last_name" required>
          </div>
          <div class="form-group">
            <label for="editGender">Gender</label>
            <select class="form-control" id="editGender" name="gender" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
          <div class="form-group">
            <label for="editPhone">Phone</label>
            <input type="text" class="form-control" id="editPhone" name="phone" required>
          </div>
          <div class="form-group">
            <label for="editBirthday">Birthday</label>
            <input type="date" class="form-control" id="editBirthday" name="birthday" required>
          </div>
          <div class="form-group">
            <label for="editAddress">Address</label>
            <textarea class="form-control" id="editAddress" name="address" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCustomerChanges">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#customersTable').DataTable();
  });
</script>
@endsection