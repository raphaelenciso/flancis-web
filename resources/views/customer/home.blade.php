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
      <div id="promoCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @if(count($promos) > 0)
            @foreach($promos as $index => $promo)
              <li data-target="#promoCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
          @else
            <li data-target="#promoCarousel" data-slide-to="0" class="active"></li>
          @endif
        </ol>
        <div class="carousel-inner">
          @if(count($promos) > 0)
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
          @else
            <div class="carousel-item active">
              <div class="no-promos-slide">
                <h5>No Promos Available</h5>
                <p>Check back later for exciting promotions!</p>
              </div>
            </div>
          @endif
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

      <!-- Top Services Card -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Top Services</h6>
        </div>
        <div class="card-body">
          @php
          $colors = ['danger', 'success', 'warning', 'info', 'primary'];
          $colorIndex = 0;
          @endphp
          @foreach($topServices as $service)
          @php
          $name = $service->name;
          $rating = round($service->avg_rating, 1);
          $ratingCount = $service->rating_count;
          $color = $colors[$colorIndex % count($colors)];
          $width = $rating * 20;

          $fullStars = floor($rating);
          $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
          $emptyStars = 5 - $fullStars - $halfStar;

          $stars = str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
          $stars .= $halfStar ? '<i class="fas fa-star-half-alt text-warning"></i>' : '';
          $stars .= str_repeat('<i class="far fa-star text-warning"></i>', $emptyStars);

          $colorIndex++;
          @endphp
          <h4 class="small font-weight-bold text-{{ $color }}">
            {{ $name }} <span class="float-right">{!! $stars !!} ({{ $rating }}) - {{ $ratingCount }} ratings</span>
          </h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $width }}%"
              aria-valuenow="{{ $width }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4 mb-4">
      <!-- Service Types Carousel -->
      <div id="serviceTypeCarousel" class="carousel slide" data-ride="carousel">
        <div class="service-label">Our Services</div>
        <ol class="carousel-indicators">
          @if(count($serviceTypes) > 0)
            @foreach($serviceTypes as $index => $serviceType)
              <li data-target="#serviceTypeCarousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
          @else
            <li data-target="#serviceTypeCarousel" data-slide-to="0" class="active"></li>
          @endif
        </ol>
        <div class="carousel-inner">
          @if(count($serviceTypes) > 0)
            @foreach($serviceTypes as $index => $serviceType)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
              <img src="{{ asset($serviceType->service_image) }}" class="d-block w-100" alt="{{ $serviceType->service_type }}">
              <div class="carousel-caption d-none d-md-block">
                <h5>{{ $serviceType->service_type }}</h5>
                <p>
                  @foreach($serviceType->services as $service)
                    <span class="badge badge-light">{{ $service->service_name }}</span>
                  @endforeach
                </p>
              </div>
            </div>
            @endforeach
          @else
            <div class="carousel-item active">
              <div class="no-services-slide">
                <h5>Our Services</h5>
                <p>No services available at the moment.</p>
              </div>
            </div>
          @endif
        </div>
        <a class="carousel-control-prev" href="#serviceTypeCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#serviceTypeCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <!-- Recent Activities Card -->
      <div class="card shadow  mt-4">
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
    $('#serviceTypeCarousel').carousel({
      interval: 3000
    });
  });
</script>
@endpush