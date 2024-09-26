@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/customer/signin.css') }}">
@endsection

@section('content')
<h1>Forgot Password</h1>
<div class="container">
  <form action="/forgot-password" method="POST" class="signin-form">
    @csrf
    <h2>Reset Password</h2>
    @if (session('status'))
    <p class="success-message">{{ session('status') }}</p>
    @endif
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
      <label for="email"><i class="fas fa-envelope"></i></label>
      <input type="email" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
    </div>
    <button type="submit" class="btn">Send Password Reset Link</button>
    <p><a href="/signin">Back to Sign In</a></p>
  </form>
</div>
@endsection