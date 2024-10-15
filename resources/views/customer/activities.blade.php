@extends('layouts.customer')

@section('title', 'Activities')

@section('links')
<link href="{{ asset('css/customer/activities.css') }}" rel="stylesheet">
@endsection

@php
if (!function_exists('getStatusClass')) {
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
}
@endphp


@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">
    {{ Auth::check() ? 'Good ' . (date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening')) . ', ' . Auth::user()->username : 'Activities' }}
  </h1>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Activities</h6>
        <div class="search-box">
          <form action="{{ url('/customer/activities') }}" method="GET">
            <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search services..." value="{{ $search ?? '' }}">
          </form>
        </div>
      </div>
      <div class="card-body">
        <ul class="nav nav-tabs" id="appointmentTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab">Upcoming</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="recent-tab" data-toggle="tab" href="#recent" role="tab">Recent</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab">Cancelled</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab">Rejected</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab">Completed</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab">All</a>
          </li>
        </ul>
        <div class="tab-content mt-3" id="appointmentTabContent">
          @foreach(['upcoming', 'recent', 'cancelled', 'rejected', 'completed', 'all'] as $tabName)
          <div class="tab-pane fade {{ $tabName === 'upcoming' ? 'show active' : '' }}" id="{{ $tabName }}" role="tabpanel">
            <div class="appointment-list">
              @if($appointmentsByCategory[$tabName]->isEmpty())
              <p>No appointments found.</p>
              @else
              @foreach($appointmentsByCategory[$tabName] as $appointment)
              <div class="card mb-3 appointment-card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <img src="{{ $appointment->service->serviceType->service_image ? asset( $appointment->service->serviceType->service_image) : asset('img/default-service-type.jpg') }}" alt="{{ $appointment->service->serviceType->service_type }}" class="service-image">
                    <h5 class="card-title mb-0 ml-3">{{ $appointment->service->serviceType->service_type }} - {{ $appointment->service->service_name }}</h5>
                  </div>
                  @if(in_array($appointment->status, ['rejected', 'cancelled']))
                  <button class="btn btn-info btn-sm view-reason-btn"
                    onclick="openReasonModal('{{ $appointment->appointment_id }}', '{{ $appointment->admin_note }}', '{{ $appointment->status == 'rejected' ? 'Rejection' : 'Cancellation' }}')">
                    View Reason
                  </button>
                  @endif
                  @if($appointment->status == 'completed')
                  @if($appointment->is_rated)
                  <div class='rating-stars'>{{ $appointment->serviceRating->rating }} <i class="fas fa-star text-warning"></i></div>
                  @else
                  <button class="btn btn-primary btn-sm rate-service-btn" onclick="openRatingModal('{{ $appointment->appointment_id }}', '{{ $appointment->service->service_name }}')">
                    Rate Service
                  </button>
                  @endif
                  @endif
                </div>
                <div class="card-body">
                  <h6 class="card-subtitle mb-2 text-muted">
                    <i class="fas fa-calendar-alt mr-2"></i>{{ $appointment->appointment_date->format('F j, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}
                  </h6>
                  <p class="card-text">
                    <span class="badge badge-{{ getStatusClass($appointment->status) }} mb-2">{{ $appointment->status }}</span><br>
                    <strong>Payment:</strong> {{ $appointment->payment_type }}<br>
                    <strong>Price:</strong>
                    @if($appointment->promo)
                    <span class="text-muted text-decoration-line-through"> ₱{{ number_format($appointment->service->price, 2) }}
                      <span class="text-success font-weight-bold">₱{{ number_format($appointment->price, 2) }}</span>
                      <span class="badge badge-success">{{ $appointment->promo->promo_name }}</span>
                      @else
                      ₱{{ number_format($appointment->price, 2) }}
                      @endif
                      <br>
                      <strong>Remarks:</strong> {{ $appointment->remarks }}
                  </p>
                </div>
              </div>
              @endforeach
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ratingModalLabel">Rate Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ratingForm">
          <input type="hidden" id="appointmentId" name="appointmentId">
          <div class="form-group">
            <label for="serviceNameDisplay">Service:</label>
            <p id="serviceNameDisplay"></p>
          </div>
          <div class="form-group">
            <label for="rating">Rating:</label>
            <div class="star-rating">
              @for($i = 5; $i >= 1; $i--)
              <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required /><label for="star{{ $i }}"></label>
              @endfor
            </div>
          </div>
          <div class="form-group">
            <label for="ratingDescription">Description:</label>
            <select class="form-control" id="ratingDescription" name="ratingDescription" required>
              <option value="">Select a description</option>
              <option value="The service exceeded my expectations.">The service exceeded my expectations.</option>
              <option value="I am satisfied with the overall quality of the service.">I am satisfied with the overall quality of the service.</option>
              <option value="The service met my needs but could be improved.">The service met my needs but could be improved.</option>
              <option value="There were some issues with the service that need attention.">There were some issues with the service that need attention.</option>
              <option value="I am not satisfied with the service.">I am not satisfied with the service.</option>
              <option value="The service was delivered on time and as expected.">The service was delivered on time and as expected.</option>
              <option value="Communication was excellent throughout the process.">Communication was excellent throughout the process.</option>
              <option value="The service did not meet the promised standards.">The service did not meet the promised standards.</option>
              <option value="I would highly recommend this service to others.">I would highly recommend this service to others.</option>
              <option value="I encountered delays and poor communication during the service.">I encountered delays and poor communication during the service.</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitRating()">Submit Rating</button>
      </div>
    </div>
  </div>
</div>

<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonModalLabel">Appointment Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="appointmentReason"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function openRatingModal(appointmentId, serviceName) {
    $('#appointmentId').val(appointmentId);
    $('#serviceNameDisplay').text(serviceName);
    $('#ratingModal').modal('show');
  }

  function submitRating() {
    const appointmentId = $('#appointmentId').val();
    const rating = $('input[name="rating"]:checked').val();
    const description = $('#ratingDescription').val();

    if (!rating || !description) {
      alert('Please provide both a rating and a description.');
      return;
    }

    $.ajax({
      url: '/customer/submit-rating',
      method: 'POST',
      data: {
        appointmentId: appointmentId,
        rating: rating,
        description: description,
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        alert('Rating submitted successfully!');
        $('#ratingModal').modal('hide');
        location.reload();
      },
      error: function(error) {
        console.log(error);
        alert('Error submitting rating. Please try again.');
      }
    });
  }

  function openReasonModal(appointmentId, adminNote, modalType) {
    $('#reasonModalLabel').text(modalType + ' Reason');
    $('#appointmentReason').text(adminNote || 'No reason provided.');
    $('#reasonModal').modal('show');
  }

  $(document).ready(function() {
    $('#appointmentTabs a').on('click', function(e) {
      e.preventDefault()
      $(this).tab('show')
    })

    $('#searchInput').on('keyup', function(e) {
      if (e.key === 'Enter') {
        $(this).closest('form').submit();
      }
    });
  });
</script>
@endsection