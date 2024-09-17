@extends('layouts.customer')

@section('title', 'Profile')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Profile Settings</h1>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Profile Form -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
  </div>
  <div class="card-body">
    <form method="POST" action="/customer/profile">
      @csrf
      @method('PUT')
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
      <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>
  </div>
</div>
@endsection