@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800 mb-0">Profile Settings</h1>
    <a href="/admin/customers" class="btn btn-secondary">Go Back</a>
</div>

<x-customer-edit-form :user="$user" />
@endsection