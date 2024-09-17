@extends('layouts.customer')

@section('title', 'Home')


@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

  @if(Auth::check())
  @php
  date_default_timezone_set('Asia/Manila');
  $hour = date('H');
  $greeting = 'Good evening';
  if ($hour >= 5 && $hour < 12) {
    $greeting='Good morning' ;
    } elseif ($hour>= 12 && $hour < 18) {
      $greeting='Good afternoon' ;
      }
      @endphp
      <h1 class="h3 mb-0 text-gray-800">{{ $greeting }}, {{ Auth::user()->username }}</h1>
      @endif
</div>

<!-- Content Row -->
<div class="row">
  <div class="row">
    <!-- Book a Service Card -->
    <div class="col-xl-6 col-md-6 mb-4">
      <a href="/customer/book-appointment" class="card border-left-primary shadow h-100 py-2 text-decoration-none">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Book a Service
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                Schedule Your Activities
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-plus fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Check Activities Card -->
    <div class="col-xl-6 col-md-6 mb-4">
      <a href="/customer/activities" class="card border-left-success shadow h-100 py-2 text-decoration-none">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Check Activities
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                View Your Recent Activities
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection