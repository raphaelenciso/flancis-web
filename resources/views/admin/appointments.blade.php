@extends('layouts.admin')

@section('styles')
<!-- DataTables CSS -->
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
  <div class="card-header py-3">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="#all" data-toggle="tab">All</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#pending" data-toggle="tab">Pending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#confirmed" data-toggle="tab">Confirmed</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#rejected" data-toggle="tab">Rejected</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#cancelled" data-toggle="tab">Cancelled</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#completed" data-toggle="tab">Completed</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane fade show active" id="all">
        <x-appointment-table :appointments="$appointments" id="allAppointmentsTable" />
      </div>
      <div class="tab-pane fade" id="pending">
        <x-appointment-table :appointments="$appointments->where('status', 'pending')" id="pendingAppointmentsTable" />
      </div>
      <div class="tab-pane fade" id="confirmed">
        <x-appointment-table :appointments="$appointments->where('status', 'confirmed')" id="confirmedAppointmentsTable" />
      </div>
      <div class="tab-pane fade" id="rejected">
        <x-appointment-table :appointments="$appointments->where('status', 'rejected')" id="rejectedAppointmentsTable" />
      </div>
      <div class="tab-pane fade" id="cancelled">
        <x-appointment-table :appointments="$appointments->where('status', 'cancelled')" id="cancelledAppointmentsTable" />
      </div>
      <div class="tab-pane fade" id="completed">
        <x-appointment-table :appointments="$appointments->where('status', 'completed')" id="completedAppointmentsTable" />
      </div>
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
          <div class="form-group" id="balance_group" style="display: none;">
            <label for="edit_balance">Balance</label>
            <input type="text" class="form-control" id="edit_balance" name="balance" readonly>
          </div>
          <div class="form-group" id="employee_selection" style="display: none;">
            <label for="edit_employee">Assign Employee</label>
            <select class="form-control" id="edit_employee" name="employee_id">
              <option value="">Select an employee</option>
              <!-- We'll populate this dynamically with JavaScript -->
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
    var allTable = $('#allAppointmentsTable').DataTable();
    var pendingTable = $('#pendingAppointmentsTable').DataTable();
    var confirmedTable = $('#confirmedAppointmentsTable').DataTable();
    var rejectedTable = $('#rejectedAppointmentsTable').DataTable();
    var cancelledTable = $('#cancelledAppointmentsTable').DataTable();
    var completedTable = $('#completedAppointmentsTable').DataTable();

    // Filter table based on status when tab is clicked
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      var status = $(e.target).attr("href").substr(1);
      if (status === 'all') {
        table.column(6).search('').draw();
      } else {
        table.column(6).search(status).draw();
      }
    });

    // View Appointment
    $(document).on('click', '.view-appointment-btn', function() {
      var id = $(this).data('id');
      $.ajax({
        url: '/admin/appointments/' + id,
        type: 'GET',
        success: function({
          appointment: data
        }) {
          var statusClass = getStatusClass(data.status);
          var proofUrl = data.proof ? "{{ asset('') }}" + data.proof : null;
          var formattedDate = formatDate(data.appointment_date);
          var formattedTime = formatTime(data.appointment_time);
          var originalPrice = parseFloat(data.service.price);
          var finalPrice = parseFloat(data.price);
          var balance = parseFloat(data.balance);
          var detailsHtml = `
            <div class="d-flex flex-wrap">
              <div class="col-md-6 mb-3">
                <p><strong>Appointment ID:</strong> ${data.appointment_id}</p>
                <p><strong>User:</strong> ${data.user.first_name} ${data.user.last_name}</p>
                <p><strong>Date:</strong> ${formattedDate}</p>
                <p><strong>Time:</strong> ${formattedTime}</p>
                <p><strong>Service:</strong> ${data.service.service_name}</p>
                <p><strong>Price:</strong> 
                  ${data.promo ? 
                    `<span class="text-muted text-decoration-line-through"> ₱${originalPrice.toFixed(2)}</span> 
                     <span class="text-success font-weight-bold">₱${finalPrice.toFixed(2)}</span>
                     <span class="badge badge-success">${data.promo.promo_name}</span>` 
                    : 
                    `₱${finalPrice.toFixed(2)}`
                  }
                </p>
                <p><strong>Balance:</strong> ₱${balance.toFixed(2)}</p>
                <p><strong>Payment Type:</strong> ${data.payment_type}</p>
              </div>
              <div class="col-md-6 mb-3">
                <p><strong>Status:</strong> <span class="badge badge-${statusClass}">${data.status}</span></p>
                <p><strong>Remarks:</strong> ${data.remarks || 'N/A'}</p>
                <p><strong>Admin Note:</strong> ${data.admin_note || 'N/A'}</p>
                <p><strong>Proof:</strong> ${proofUrl ? `<a href="${proofUrl}" target="_blank">View Proof</a>` : 'No proof uploaded'}</p>
                <p><strong>Date booked:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                <p><strong>Assigned Employee:</strong> ${data.employee ? `${data.employee.employee_first_name} ${data.employee.employee_last_name}` : 'Not assigned'}</p>
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
      $.get('/admin/appointments/' + id, function(response) {
        var data = response.appointment;
        var employees = response.employees;

        $('#edit_appointment_id').val(data.appointment_id);
        $('#edit_status').val(data.status);
        $('#edit_admin_note').val(data.admin_note);
        $('#edit_appointment_id').data('original-status', data.status);
        $('#edit_appointment_id').data('price', data.price);

        populateEmployeeSelect(employees, data.employee_id);
        updateFormBasedOnStatus(data.status, data.status);

        $('#editAppointmentModal').modal('show');
      });
    });

    // Status change handler
    $('#edit_status').change(function() {
      var originalStatus = $('#edit_appointment_id').data('original-status');
      var newStatus = $(this).val();

      updateFormBasedOnStatus(originalStatus, newStatus);
    });

    function updateFormBasedOnStatus(originalStatus, newStatus) {
      var price = parseFloat($('#edit_appointment_id').data('price'));

      if (originalStatus === 'pending' || originalStatus === 'confirmed') {
        if (newStatus !== 'pending') {
          var balance = price / 2;
          $('#edit_balance').val(balance.toFixed(2));
          $('#balance_group').show();
        } else {
          $('#balance_group').hide();
        }

        if (newStatus === 'confirmed' || newStatus === 'completed') {
          $('#employee_selection').show();
          $('#edit_employee').prop('disabled', false);
        } else {
          $('#employee_selection').hide();
        }
      } else {
        $('#balance_group').hide();
        $('#employee_selection').show();
        $('#edit_employee').prop('disabled', true);
      }
    }

    function populateEmployeeSelect(employees, selectedEmployeeId) {
      var options = '<option value="">Select an employee</option>';
      employees.forEach(function(employee) {
        var selected = employee.employee_id === selectedEmployeeId ? 'selected' : '';
        options += `<option value="${employee.employee_id}" ${selected}>${employee.employee_first_name} ${employee.employee_last_name}</option>`;
      });
      $('#edit_employee').html(options);
    }

    // Update Appointment
    $('#editAppointmentForm').submit(function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var id = $('#edit_appointment_id').val();

      $.ajax({
        url: '/admin/appointments/' + id,
        type: 'PUT',
        data: formData,
        success: function(response) {
          $('#editAppointmentModal').modal('hide');
          // Refresh the appointments list or update the specific row
          location.reload();
        },
        error: function(xhr) {
          // Handle errors
          console.error(xhr.responseText);
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

    function calculateFinalPrice(price, promo) {
      if (promo) {
        return price * (1 - promo.percent_discount / 100);
      }
      return price;
    }
  });
</script>
@endsection