@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Add this section to display validation errors -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Employee Add/Edit Form -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ isset($employee) ? 'Edit' : 'Add' }} Employee</h6>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ isset($employee) ? '/admin/employees/' . $employee->employee_id : '/admin/employees/'  }}" enctype="multipart/form-data">
      @csrf
      @if(isset($employee))
        @method('PUT')
      @endif
      
      <!-- Profile Picture Section -->
      <div class="form-group text-center mb-4">
        <label for="employee_image">Employee Picture</label>
        <div class="mb-2">
          <img   src="{{ isset($employee) && $employee->employee_image ? asset('images/employee-images/' . $employee->employee_image) : asset('images/user-placeholder.png') }}" alt="Employee Picture" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;" id="profile-image">

          

        </div>
        <input type="file" class="form-control-file d-none" id="employee_image" name="employee_image" accept="image/*">
        <button type="button" class="btn btn-primary btn-sm mt-2" id="change-picture-btn">{{ isset($employee) && $employee->employee_image ? "Change Picture" : "Add Picture"}}</button>
      </div>

      <!-- Rest of the form fields -->
      <div class="form-group row">
        @if(isset($employee) && $employee->employee_id)
        <div class="col-sm-4 mb-3 mb-sm-0">
          <label for="employee_id">Employee ID</label>
          <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ $employee->employee_id }}" readonly>
        </div>
        @endif
        <div class="col-sm-4">
          <label for="role">Role</label>
          <input type="text" class="form-control" id="role" name="role" value="{{ $employee->role ?? old('role') }}">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-4 mb-3 mb-sm-0">
          <label for="employee_first_name">First Name</label>
          <input type="text" class="form-control" id="employee_first_name" name="employee_first_name" value="{{ $employee->employee_first_name ?? old('employee_first_name') }}">
        </div>
        <div class="col-sm-4">
          <label for="employee_middle_name">Middle Name</label>
          <input type="text" class="form-control" id="employee_middle_name" name="employee_middle_name" value="{{ $employee->employee_middle_name ?? old('employee_middle_name') }}">
        </div>
        <div class="col-sm-4">
          <label for="employee_last_name">Last Name</label>
          <input type="text" class="form-control" id="employee_last_name" name="employee_last_name" value="{{ $employee->employee_last_name ?? old('employee_last_name') }}">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <label for="gender">Gender</label>
          <select class="form-control" id="gender" name="gender">
            <option value="">Select Gender</option>
            <option value="male" {{ (isset($employee) && $employee->gender === 'male') || old('gender') === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ (isset($employee) && $employee->gender === 'female') || old('gender') === 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ (isset($employee) && $employee->gender === 'other') || old('gender') === 'other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
        <div class="col-sm-6">
          <label for="birthday">Birthday</label>
          <input type="date" class="form-control" id="birthday" name="birthday" value="{{ isset($employee) ? $employee->birthday->format('Y-m-d') : old('birthday') }}">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email ?? old('email') }}">
        </div>
        <div class="col-sm-6">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" value="{{ $employee->phone ?? old('phone') }}" maxlength="11">
        </div>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" name="address" rows="3">{{ $employee->address ?? old('address') }}</textarea>
      </div>
      
      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ isset($employee) ? 'Update' : 'Add' }} Employee</button>
        <a href="/admin/employees" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

<!-- Add this JavaScript at the end of the file or in a separate JS file -->
<script>
  document.getElementById('change-picture-btn').addEventListener('click', function() {
    document.getElementById('employee_image').click();
  });

  document.getElementById('employee_image').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('profile-image').src = e.target.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  });

  document.getElementById('profile-image').addEventListener('click', function() {
    document.getElementById('employee_image').click();
  });
</script>
