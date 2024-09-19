@extends('layouts.customer')

@section('title', 'Profile')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Profile Settings</h1>

<x-customer-edit-form :user="$user" />
@endsection