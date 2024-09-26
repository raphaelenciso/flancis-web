@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Services</h1>
<p class="mb-4">Manage your services here.</p>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">All Services</h6>
    <div>
      <button class="btn btn-primary mr-2 add-service-btn">Add Service</button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Service Name</th>
            <th>Service Type</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($services as $service)
          <tr>
            <td data-description="{{ $service->description }}">{{ $service->service_name }}</td>
            <td>{{ $service->serviceType->service_type }}</td>
            <td>₱{{ number_format($service->price, 2) }}</td>
            <td>{{ $service->rating ?? 'N/A' }}</td>
            <td>{{ ucfirst($service->status) }}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-service-btn" data-id="{{ $service->service_id }}">Edit</button>
              @if(env('SUPER_ADMIN_ENABLED', false))
              <button class="btn btn-sm btn-danger delete-service-btn" data-id="{{ $service->service_id }}">Delete</button>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addServiceForm">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="service_name">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
          </div>
          <div class="form-group">
            <label for="service_type_id">Service Type</label>
            <select class="form-control" id="service_type_id" name="service_type_id" required>
              @foreach ($serviceTypes as $type)
              <option value="{{ $type->service_type_id }}">{{ $type->service_type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Service</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editServiceForm">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_service_id" name="service_id">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_service_name">Service Name</label>
            <input type="text" class="form-control" id="edit_service_name" name="service_name" required>
          </div>
          <div class="form-group">
            <label for="edit_service_type_id">Service Type</label>
            <select class="form-control" id="edit_service_type_id" name="service_type_id" required>
              @foreach ($serviceTypes as $type)
              <option value="{{ $type->service_type_id }}">{{ $type->service_type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="edit_price">Price</label>
            <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="edit_description">Description</label>
            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="edit_status">Status</label>
            <select class="form-control" id="edit_status" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Service</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this service? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // Add Service
    $('.add-service-btn').click(function() {
      $('#addServiceModal').modal('show');
    });

    $('#addServiceForm').submit(function(e) {
      e.preventDefault();
      addService();
    });

    function addService() {
      var formData = new FormData($('#addServiceForm')[0]);

      $.ajax({
        url: '/admin/services',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#addServiceModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while adding the service.');
        }
      });
    }

    // Edit Service
    $('.edit-service-btn').click(function() {
      var id = $(this).data('id');
      var row = $(this).closest('tr');
      var name = row.find('td:eq(0)').text();
      var typeText = row.find('td:eq(1)').text();
      var price = parseFloat(row.find('td:eq(2)').text().replace('$', ''));
      var description = row.find('td:eq(0)').data('description');
      var status = row.find('td:eq(4)').text().toLowerCase();

      $('#edit_service_id').val(id);
      $('#edit_service_name').val(name);
      $('#edit_service_type_id option').filter(function() {
        return $(this).text() === typeText;
      }).prop('selected', true);
      $('#edit_price').val(price);
      $('#edit_description').val(description);
      $('#edit_status').val(status);

      $('#editServiceModal').modal('show');
    });

    $('#editServiceForm').submit(function(e) {
      e.preventDefault();
      updateService();
    });

    function updateService() {
      var formData = new FormData($('#editServiceForm')[0]);
      var serviceId = $('#edit_service_id').val();

      $.ajax({
        url: '/admin/services/' + serviceId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#editServiceModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while updating the service.');
        }
      });
    }

    // Delete Service
    let deleteId;
    $('.delete-service-btn').click(function() {
      deleteId = $(this).data('id');
      $('#deleteConfirmModal').modal('show');
    });

    $('#confirmDelete').click(deleteService);

    function deleteService() {
      $.ajax({
        url: '/admin/services/' + deleteId,
        type: 'DELETE',
        data: {
          _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('button[data-id="' + deleteId + '"]').closest('tr').remove();
            $('#deleteConfirmModal').modal('hide');
          } else {
            alert(response.message);
          }
        },
        error: function(error) {
          console.log(error);
          alert('An error occurred while deleting the service.');
          $('#deleteConfirmModal').modal('hide');
        }
      });
    }
  });
</script>
@endsection