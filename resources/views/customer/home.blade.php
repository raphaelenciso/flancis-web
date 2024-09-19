@extends('layouts.customer')

@section('title', 'Home')

@section('links')
<link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
@endsection

@php
function getStatusClass($status) {
    switch ($status) {
        case 'confirmed':
            return 'success';
        case 'pending':
            return 'warning';
        case 'rejected':
        case 'cancelled':
            return 'danger';
        case 'completed':
            return 'info';
        default:
            return 'secondary';
    }
}
@endphp

@section('content')

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    @if(Auth::check())
    @php
    date_default_timezone_set('Asia/Manila');
    $hour = date('H');
    $greeting = 'Good evening';
    if ($hour >= 5 && $hour < 12) {
      $greeting='Good morning';
    } elseif ($hour >= 12 && $hour < 18) {
      $greeting='Good afternoon';
    }
    @endphp
    <h1 class="h3 mb-0 text-gray-800">{{ $greeting }}, {{ Auth::user()->username }}</h1>
    @endif
  </div>

  <div class="row">
    <!-- Left Column -->
    <div class="col-lg-8 mb-4">
      <!-- Promo Carousel -->
      @if(count($promos) > 0)
      <div id="promoCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @foreach($promos as $index => $promo)
            <li data-target="#promoCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
          @endforeach
        </ol>
        <div class="carousel-inner">
          @foreach($promos as $index => $promo)
          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <img src="{{ asset($promo->image) }}" class="d-block w-100" alt="{{ $promo->promo_name }}">
            <div class="carousel-caption d-none d-md-block">
              <h5>{{ $promo->promo_name }}</h5>
              <p class="promo-details">
                <span class="discount">{{ $promo->percent_discount }}% OFF</span>
                <span class="dates">
                  <i class="fas fa-calendar-alt"></i> 
                  {{ $promo->start_date->format('M j') }} - {{ $promo->end_date->format('M j, Y') }}
                </span>
              </p>
              <a href="/customer/book-appointment" class="btn btn-primary">Book Now</a>
            </div>
          </div>
        @endforeach
        </div>
        <a class="carousel-control-prev" href="#promoCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#promoCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      @else
      <div class="no-promos-card">
        <div class="card-body text-center">
          <h5 class="card-title">No Promos Available</h5>
          <p class="card-text">Check back later for exciting promotions!</p>
        </div>
      </div>
      @endif

      <!-- Book a Service Card -->
      <div class="row mt-4">
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 highlight-cards">
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
            <a href="/customer/book-appointment" class="card-footer text-center text-primary text-decoration-none">
              Book Now <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Check Activities Card -->
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 highlight-cards">
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
            <a href="/customer/activities" class="card-footer text-center text-success text-decoration-none">
              View Activities <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activities Card -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
        </div>
        <div class="card-body">
          @if(count($recentAppointments) > 0)
            <div class="appointment-list">
              @foreach($recentAppointments as $appointment)
                <div class="card mb-3 appointment-card">
                  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="{{ $appointment->service->serviceType->service_image ? asset($appointment->service->serviceType->service_image) : asset('img/default-service-type.jpg') }}" alt="{{ $appointment->service->serviceType->service_type }}" class="service-image">
                      <h6 class="card-title mb-0 ml-2">{{ $appointment->service->service_name }}</h6>
                    </div>
                    <span class="badge badge-{{ getStatusClass($appointment->status) }}">{{ $appointment->status }}</span>
                  </div>
                  <div class="card-body">
                    <p class="card-text">
                      <i class="fas fa-calendar-alt mr-2"></i>{{ $appointment->appointment_date->format('M j, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}
                    </p>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="text-center mt-3">
              <a href="/customer/activities" class="btn btn-primary">View All Activities</a>
            </div>
          @else
            <p class="text-center">No recent activities.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#promoCarousel').carousel({
      interval: 5000
    });
  });
</script>
@endpush