@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Service Types</h1>
<p class="mb-4">Manage your service types here.</p>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">All Service Types</h6>
    <div>
      <button class="btn btn-primary mr-2 add-service-type-btn">Add Service Type</button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Service Type</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($serviceTypes as $type)
          <tr>
            <td>{{ $type->service_type }}</td>
            <td>
              @if ($type->service_image)
              <img src="{{ asset($type->service_image) }}" alt="{{ $type->service_type }}" style="max-width: 100px; max-height: 100px;">
              @else
              No image
              @endif
            </td>
            <td>{{ ucfirst($type->status) }}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-service-type-btn" data-id="{{ $type->service_type_id }}">Edit</button>
              <button class="btn btn-sm btn-danger delete-service-type-btn" data-id="{{ $type->service_type_id }}">Delete</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Service Type Modal -->
<div class="modal fade" id="addServiceTypeModal" tabindex="-1" role="dialog" aria-labelledby="addServiceTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceTypeModalLabel">Add Service Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addServiceTypeForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="service_type">Service Type</label>
            <input type="text" class="form-control" id="service_type" name="service_type" required>
          </div>
          <div class="form-group">
            <label for="service_image">Image</label>
            <input type="file" class="form-control-file" id="service_image" name="service_image" accept="image/*">
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
          <button type="submit" class="btn btn-primary">Add Service Type</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Service Type Modal -->
<div class="modal fade" id="editServiceTypeModal" tabindex="-1" role="dialog" aria-labelledby="editServiceTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceTypeModalLabel">Edit Service Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editServiceTypeForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" id="edit_service_type_id" name="service_type_id">
          <div class="form-group">
            <label for="edit_service_type">Service Type</label>
            <input type="text" class="form-control" id="edit_service_type" name="service_type" required>
          </div>
          <div class="form-group">
            <label for="edit_service_image">Image</label>
            <input type="file" class="form-control-file" id="edit_service_image" name="service_image" accept="image/*">
            <img id="current_image" src="" alt="Current Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
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
          <button type="submit" class="btn btn-primary">Update Service Type</button>
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
        Are you sure you want to delete this service type? This action cannot be undone.
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
    // Add Service Type
    $('.add-service-type-btn').click(function() {
      $('#addServiceTypeModal').modal('show');
    });

    $('#addServiceTypeForm').submit(function(e) {
      e.preventDefault();
      addServiceType();
    });

    function addServiceType() {
      var formData = new FormData($('#addServiceTypeForm')[0]);

      $.ajax({
        url: '/admin/service-types',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#addServiceTypeModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while adding the service type.');
        }
      });
    }

    // Edit Service Type
    $('.edit-service-type-btn').click(function() {
      var id = $(this).data('id');
      var type = $(this).closest('tr').find('td:first').text();
      var status = $(this).closest('tr').find('td:nth-child(3)').text().toLowerCase();
      var imageSrc = $(this).closest('tr').find('img').attr('src');

      $('#edit_service_type_id').val(id);
      $('#edit_service_type').val(type);
      $('#edit_status').val(status);
      $('#current_image').attr('src', imageSrc);

      $('#editServiceTypeModal').modal('show');
    });

    $('#editServiceTypeForm').submit(function(e) {
      e.preventDefault();
      updateServiceType();
    });

    function updateServiceType() {
      var formData = new FormData($('#editServiceTypeForm')[0]);
      var serviceTypeId = $('#edit_service_type_id').val();

      $.ajax({
        url: '/admin/service-types/' + serviceTypeId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#editServiceTypeModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while updating the service type.');
        }
      });
    }

    // Delete Service Type
    let deleteId;
    $('.delete-service-type-btn').click(function() {
      deleteId = $(this).data('id');
      $('#deleteConfirmModal').modal('show');
    });

    $('#confirmDelete').click(deleteServiceType);

    function deleteServiceType() {
      $.ajax({
        url: '/admin/service-types/' + deleteId,
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
          alert('An error occurred while deleting the service type.');
          $('#deleteConfirmModal').modal('hide');
        }
      });
    }
  });
</script>
@endsection