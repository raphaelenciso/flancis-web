@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Resources</h1>
<p class="mb-4">Manage your resources here.</p>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">All Resources</h6>
    <div>
      <button class="btn btn-primary mr-2 add-resource-btn">Add Resource</button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Resource Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($resources as $resource)
          <tr>
            <td>{{ $resource->resource_name }}</td>
            <td>{{ $resource->quantity }}</td>
            <td>{{ ucfirst($resource->status) }}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-resource-btn" data-id="{{ $resource->resource_id }}">Edit</button>
              <button class="btn btn-sm btn-danger delete-resource-btn" data-id="{{ $resource->resource_id }}">Delete</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Resource Modal -->
<div class="modal fade" id="addResourceModal" tabindex="-1" role="dialog" aria-labelledby="addResourceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addResourceModalLabel">Add Resource</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addResourceForm">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="resource_name">Resource Name</label>
            <input type="text" class="form-control" id="resource_name" name="resource_name" required>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
              <option value="available">Available</option>
              <option value="unavailable">Unavailable</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Resource</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Resource Modal -->
<div class="modal fade" id="editResourceModal" tabindex="-1" role="dialog" aria-labelledby="editResourceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editResourceModalLabel">Edit Resource</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editResourceForm">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_resource_id" name="resource_id">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_resource_name">Resource Name</label>
            <input type="text" class="form-control" id="edit_resource_name" name="resource_name" required>
          </div>
          <div class="form-group">
            <label for="edit_quantity">Quantity</label>
            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
          </div>
          <div class="form-group">
            <label for="edit_status">Status</label>
            <select class="form-control" id="edit_status" name="status" required>
              <option value="available">Available</option>
              <option value="unavailable">Unavailable</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Resource</button>
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
        Are you sure you want to delete this resource? This action cannot be undone.
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
    // Add Resource
    $('.add-resource-btn').click(function() {
      $('#addResourceModal').modal('show');
    });

    $('#addResourceForm').submit(function(e) {
      e.preventDefault();
      addResource();
    });

    function addResource() {
      var formData = new FormData($('#addResourceForm')[0]);

      $.ajax({
        url: '/admin/resources',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#addResourceModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while adding the resource.');
        }
      });
    }

    // Edit Resource
    $('.edit-resource-btn').click(function() {
      var id = $(this).data('id');
      var row = $(this).closest('tr');
      var name = row.find('td:eq(0)').text();
      var quantity = row.find('td:eq(1)').text();
      var status = row.find('td:eq(2)').text().toLowerCase();

      $('#edit_resource_id').val(id);
      $('#edit_resource_name').val(name);
      $('#edit_quantity').val(quantity);
      $('#edit_status').val(status);

      $('#editResourceModal').modal('show');
    });

    $('#editResourceForm').submit(function(e) {
      e.preventDefault();
      updateResource();
    });

    function updateResource() {
      var formData = new FormData($('#editResourceForm')[0]);
      var resourceId = $('#edit_resource_id').val();

      $.ajax({
        url: '/admin/resources/' + resourceId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#editResourceModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while updating the resource.');
        }
      });
    }

    // Delete Resource
    let deleteId;
    $('.delete-resource-btn').click(function() {
      deleteId = $(this).data('id');
      $('#deleteConfirmModal').modal('show');
    });

    $('#confirmDelete').click(deleteResource);

    function deleteResource() {
      $.ajax({
        url: '/admin/resources/' + deleteId,
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
          alert('An error occurred while deleting the resource.');
          $('#deleteConfirmModal').modal('hide');
        }
      });
    }
  });
</script>
@endsection