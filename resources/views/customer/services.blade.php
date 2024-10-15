@extends('layouts.customer')

@section('title', 'Services')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Our Services</h1>

@foreach($serviceTypes as $serviceType)
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ $serviceType->service_type }}</h6>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 mb-4">
        <img src="{{ asset($serviceType->service_image) }}" alt="{{ $serviceType->service_type }}" class="img-fluid rounded">
      </div>
      <div class="col-md-9">
        <div class="row">
          @foreach($serviceType->services as $service)
          <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="row no-gutters">
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">{{ $service->service_name }}</h5>
                    <p class="card-text">{{ $service->description }}</p>
                    <p class="card-text"><strong>Price:</strong> ₱{{ number_format($service->price, 2) }}</p>
                    @if($service->rating)
                    <p class="card-text">
                      <strong>Rating:</strong>
                      {{ number_format($service->rating, 1) }}
                      <i class="fas fa-star text-warning"></i>
                    </p>
                    @endif
                  </div>
                </div>
                <div class="col-md-4">
                  @if($service->service_image)
                  <img src="{{ asset($service->service_image) }}" alt="{{ $service->service_name }}" class="img-fluid h-100 object-fit-cover">
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection