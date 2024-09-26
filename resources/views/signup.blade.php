@extends('layouts.auth')

@section('title', 'Sign Up')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/customer/signup.css') }}">
@endsection

@section('content')
<div class="container">
  <h2 class="text-center mb-4">Sign Up</h2>
  @if (session('message'))
  <div class="alert {{ strpos(session('message'), 'successful') !== false ? 'alert-success' : 'alert-danger' }}" role="alert">
    {!! session('message') !!}
  </div>
  @endif

  @if (session('show_otp_form'))
  <form action="/verify-otp" method="POST">
    @csrf
    <div class="form-group">
      <label for="otp">Enter OTP</label>
      <input type="text" class="form-control" id="otp" name="otp" required>
    </div>
    <button type="submit" class="btn" name="verify_otp">Verify OTP</button>
  </form>
  @else
  <form action="/signup" method="POST">
    @csrf
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="middle_name">Middle Name</label>
          <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" maxlength="1">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="birthday">Birthday</label>
          <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="gender">Gender</label>
          <select class="form-control" id="gender" name="gender" required>
            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="others" {{ old('gender') == 'others' ? 'selected' : '' }}>Others</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="password-toggle" onclick="togglePassword('password')">
              <i class="fas fa-eye"></i>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            <span class="password-toggle" onclick="togglePassword('password_confirmation')">
              <i class="fas fa-eye"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <button type="submit" class="btn" name="signup">Sign Up</button>
    <p>Already have an account? <a href="/signin">Sign In</a></p>
  </form>
  @endif
</div>



@endsection

@section('scripts')
<script>
  function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const icon = passwordInput.nextElementSibling.querySelector('i');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>
@endsection