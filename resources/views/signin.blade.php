@extends('layouts.auth')

@section('title', 'Sign In')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/customer/signin.css') }}">
@endsection

@section('content')
<h1>WELCOME</h1>
<div class="container">
  <form action="/signin" method="POST" class="signin-form">
    @csrf
    <h2>Sign in</h2>
    @if (session('error'))
    <p class="error-message">{{ session('error') }}</p>
    @endif
    <div class="input-field">
      <label for="username"><i class="fas fa-user"></i></label>
      <input type="text" id="username" name="username" placeholder="Username" required value="{{ old('username') }}">
    </div>
    <div class="input-field">
      <label for="password"><i class="fas fa-lock"></i></label>
      <input type="password" id="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" class="btn" name="login">Sign In</button>
    <p>Don't have an account? <a href="/signup">Sign up</a></p>
  </form>
</div>
@endsection