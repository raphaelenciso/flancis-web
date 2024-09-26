@extends('layouts.auth')

@section('title', 'Reset Password')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/customer/signin.css') }}">
@endsection

@section('content')
<h1>Reset Password</h1>
<div class="container">
  <form action="/reset-password" method="POST" class="signin-form">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <h2>Create New Password</h2>
    @if (session('error'))
    <p class="error-message">{{ session('error') }}</p>
    @endif
    @if ($errors->any())
    <div class="error-message">
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
    <div class="input-field">
      <label for="password"><i class="fas fa-lock"></i></label>
      <div class="password-input-wrapper">
        <input type="password" id="password" name="password" placeholder="New Password" required>
        <span class="password-toggle" onclick="togglePassword('password')">
          <i class="fas fa-eye"></i>
        </span>
      </div>
    </div>
    <div class="input-field">
      <label for="password_confirmation"><i class="fas fa-lock"></i></label>
      <div class="password-input-wrapper">
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" required>
        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
          <i class="fas fa-eye"></i>
        </span>
      </div>
    </div>
    <button type="submit" class="btn">Reset Password</button>
  </form>
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