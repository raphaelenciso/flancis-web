@extends('layouts.admin')

@section('title', 'Ratings')

@section('content')

  <h1 class="h3 mb-2 text-gray-800">Ratings</h1>
  <p class="mb-4">View customer ratings and feedback here.</p>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Ratings List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="ratingsTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Service</th>
              <th>Rating</th>
              <th>Date</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ratings as $rating)
            <tr>
              <td>{{ $rating->user->first_name }} {{ $rating->user->last_name }}</td>
              <td>{{ $rating->service->service_name }}</td>
              <td>
                <div class='rating-stars'>
                  {{ $rating->rating }} <i class="fas fa-star text-warning"></i>
                </div>
              </td>
              <td>{{ $rating->created_at->format('Y-m-d') }}</td>
              <td>
                @if(strlen($rating->description) > 65)
                  {{ substr($rating->description, 0, 65) }}...
                  <button class="btn btn-link btn-sm view-more" data-id="{{ $rating->rating_id }}">See More</button>
                @else
                  {{ $rating->description }}
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreModal" tabindex="-1" role="dialog" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewMoreModalLabel">Full Description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="viewMoreDetails">
        <!-- Full description will be populated here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('styles')
<style>
  #ratingsTable td {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  #ratingsTable .view-more {
    padding: 0;
    vertical-align: baseline;
    font-size: 0.9em;
  }
</style>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#ratingsTable').DataTable();

    $('.view-more').click(function() {
      var ratingId = $(this).data('id');
      $.ajax({
        url: '/admin/ratings/' + ratingId,
        type: 'GET',
        success: function(response) {
          var modalBody = $('#viewMoreDetails');
          modalBody.html(`
            <p><strong>Customer:</strong> ${response.user.first_name} ${response.user.last_name}</p>
            <p><strong>Service:</strong> ${response.service.service_name}</p>
            <p><strong>Rating:</strong> ${response.rating} <i class="fas fa-star text-warning"></i></p>
            <p><strong>Date:</strong> ${new Date(response.created_at).toISOString().split('T')[0]}</p>
            <p><strong>Description:</strong> ${response.description}</p>
          `);
          $('#viewMoreModal').modal('show');
        },
        error: function(xhr) {
          console.error('Error fetching rating details:', xhr);
        }
      });
    });
  });
</script>
@endsection
