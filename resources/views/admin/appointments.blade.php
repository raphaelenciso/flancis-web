@extends('layouts.admin')

@section('styles')
<!-- DataTables CSS -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
  /* Custom styles for appointment details */
  #appointmentDetails p {
    margin-bottom: 0.5rem;
  }

  #appointmentDetails img {
    max-width: 100%;
    height: auto;
    margin-top: 1rem;
  }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Appointments</h1>
<p class="mb-4">Manage your appointments here.</p>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">All Appointments</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="appointmentsTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Appointment ID</th>
            <th>User</th>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Payment Type</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($appointments as $appointment)
          <tr>
            <td>{{ $appointment->appointment_id }}</td>
            <td>{{ $appointment->user->first_name . ' ' . $appointment->user->last_name }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
            <td>{{ $appointment->service->service_name }}</td>
            <td>{{ $appointment->payment_type }}</td>
            <td>
              @php
              $statusClass = match($appointment->status) {
              'pending' => 'warning',
              'confirmed' => 'success',
              'rejected', 'cancelled' => 'danger',
              'completed' => 'info',
              default => 'secondary'
              };
              @endphp
              <span class="badge badge-{{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
            </td>
            <td>
              <button class="btn btn-sm btn-info view-appointment-btn" data-id="{{ $appointment->appointment_id }}">View</button>
              <button class="btn btn-sm btn-primary edit-appointment-btn" data-id="{{ $appointment->appointment_id }}">Update</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="appointmentDetails"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAppointmentModalLabel">Update Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editAppointmentForm">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_appointment_id" name="appointment_id">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_status">Status</label>
            <select class="form-control" id="edit_status" name="status" required>
              <option value="pending">Pending</option>
              <option value="confirmed">Confirmed</option>
              <option value="rejected">Rejected</option>
              <option value="cancelled">Cancelled</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_admin_note">Admin Note</label>
            <textarea class="form-control" id="edit_admin_note" name="admin_note" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Appointment</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<!-- DataTables JavaScript -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  $(document).ready(function() {
    $('#appointmentsTable').DataTable();

    // View Appointment
    $(document).on('click', '.view-appointment-btn', function() {
      var id = $(this).data('id');
      $.ajax({
        url: '/admin/appointments/' + id,
        type: 'GET',
        success: function(data) {
          var statusClass = getStatusClass(data.status);
          var proofUrl = data.proof ? "{{ asset('') }}" + data.proof : null;
          var formattedDate = formatDate(data.appointment_date);
          var formattedTime = formatTime(data.appointment_time);
          var detailsHtml = `
                    <div class="d-flex flex-wrap">
                        <div class="col-md-6 mb-3">
                            <p><strong>Appointment ID:</strong> ${data.appointment_id}</p>
                            <p><strong>User:</strong> ${data.user.first_name} ${data.user.last_name}</p>
                            <p><strong>Date:</strong> ${formattedDate}</p>
                            <p><strong>Time:</strong> ${formattedTime}</p>
                            <p><strong>Service:</strong> ${data.service.service_name}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Payment Type:</strong> ${data.payment_type}</p>
                            <p><strong>Status:</strong> <span class="badge badge-${statusClass}">${data.status}</span></p>
                            <p><strong>Remarks:</strong> ${data.remarks || 'N/A'}</p>
                            <p><strong>Admin Note:</strong> ${data.admin_note || 'N/A'}</p>
                            <p><strong>Proof:</strong> ${proofUrl ? `<a href="${proofUrl}" target="_blank">View Proof</a>` : 'No proof uploaded'}</p>
                        </div>
                    </div>
                `;

          if (proofUrl) {
            detailsHtml += `
                        <div class="mt-3">
                            <img src="${proofUrl}" alt="Proof" class="img-fluid" />
                        </div>
                    `;
          }

          $('#appointmentDetails').html(detailsHtml);
          $('#viewAppointmentModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error("Error fetching appointment details:", error);
          alert("An error occurred while fetching appointment details. Please try again.");
        }
      });
    });

    // Edit Appointment
    $('.edit-appointment-btn').click(function() {
      var id = $(this).data('id');
      $.get('/admin/appointments/' + id, function(data) {
        $('#edit_appointment_id').val(data.appointment_id);
        $('#edit_status').val(data.status);
        $('#edit_admin_note').val(data.admin_note);
        $('#editAppointmentModal').modal('show');
      });
    });

    $('#editAppointmentForm').submit(function(e) {
      e.preventDefault();
      var id = $('#edit_appointment_id').val();
      var formData = $(this).serialize();
      $.ajax({
        url: '/admin/appointments/' + id,
        type: 'PUT',
        data: formData,
        success: function(response) {
          if (response.success) {
            $('#editAppointmentModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          alert('An error occurred while updating the appointment.');
        }
      });
    });

    function getStatusClass(status) {
      switch (status) {
        case 'pending':
          return 'warning';
        case 'confirmed':
          return 'success';
        case 'rejected':
        case 'cancelled':
          return 'danger';
        case 'completed':
          return 'info';
        default:
          return 'secondary';
      }
    }

    function formatDate(dateString) {
      var date = new Date(dateString);
      return date.getFullYear() + '-' +
        String(date.getMonth() + 1).padStart(2, '0') + '-' +
        String(date.getDate()).padStart(2, '0');
    }

    function formatTime(timeString) {
      var [hours, minutes] = timeString.split(':');
      var hour = parseInt(hours, 10);
      var ampm = hour >= 12 ? 'PM' : 'AM';
      hour = hour % 12;
      hour = hour ? hour : 12; // the hour '0' should be '12'
      return hour + ':' + minutes + ' ' + ampm;
    }
  });
</script>
@endsection