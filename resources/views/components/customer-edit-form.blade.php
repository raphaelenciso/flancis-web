@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

<!-- Profile Form -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
  </div>
  <div class="card-body">
    <form method="POST" action="/profile" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Profile Picture Section -->
      <div class="form-group text-center mb-4">
        <label for="picture">Profile Picture</label>
        <div class="mb-2">

          <img src="{{ $user->picture ? asset('images/customer-pictures/' . $user->picture) : asset('images/user-placeholder.png') }} " alt="Current Profile Picture" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;" id="profile-image">

        </div>
        <input type="file" class="form-control-file d-none" id="picture" name="picture" accept="image/*">

        <button type="button" class="btn btn-primary btn-sm mt-2" id="change-picture-btn">{{ $user->picture ? "Change Picture" : "Add Picture"}}</button>

      </div>

      <!-- Rest of the form fields -->
      <div class="form-group row">
        <div class="col-sm-4 mb-3 mb-sm-0">
          <label for="user_id">User ID</label>
          <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}" readonly>
        </div>
        <div class="col-sm-4">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" readonly>
        </div>
        <div class="col-sm-4">
          <label for="role">Role</label>
          <input type="text" class="form-control" id="role" name="role" value="{{ $user->role }}" readonly>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-4 mb-3 mb-sm-0">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
        </div>
        <div class="col-sm-4">
          <label for="middle_name">Middle Name</label>
          <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $user->middle_name }}">
        </div>
        <div class="col-sm-4">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <label for="gender">Gender</label>
          <select class="form-control" id="gender" name="gender" required>
            <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
        <div class="col-sm-6">
          <label for="birthday">Birthday</label>
          <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $user->birthday->format('Y-m-d') }}" required>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
        </div>
        <div class="col-sm-6">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required maxlength="11">
        </div>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" name="address" rows="3" required>{{ $user->address }}</textarea>
      </div>

      <!-- New password fields -->
      <div class="form-group row">
        <div class="col-sm-4 mb-3 mb-sm-0">
          <label for="current_password">Current Password</label>
          <input type="password" class="form-control" id="current_password" name="current_password">
        </div>
        <div class="col-sm-4">
          <label for="new_password">New Password</label>
          <input type="password" class="form-control" id="new_password" name="new_password">
        </div>
        <div class="col-sm-4">
          <label for="new_password_confirmation">Confirm New Password</label>
          <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
        </div>
      </div>

      <div class="form-group">
        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

<!-- Add this JavaScript at the end of the file or in a separate JS file -->
<script>
  document.getElementById('change-picture-btn').addEventListener('click', function() {
    document.getElementById('picture').click();
  });

  document.getElementById('picture').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('profile-image').src = e.target.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  });

  document.getElementById('profile-image').addEventListener('click', function() {
    document.getElementById('picture').click();
  });
</script>