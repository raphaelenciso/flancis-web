


@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Promos</h1>
<p class="mb-4">Manage your promos here.</p>

<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold text-primary">All Promos</h6>
    <div>
      <button class="btn btn-primary mr-2 add-promo-btn">Add Promo</button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Promo Name</th>
            <th>Image</th>
            <th>Discount (%)</th>
            <th>Services</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($promos as $promo)
          <tr>
            <td>{{ $promo->promo_name }}</td>
            <td>
              @if ($promo->image)
              <img src="{{ asset($promo->image) }}" alt="{{ $promo->promo_name }}" style="max-width: 100px; max-height: 100px;">
              @else
              No image
              @endif
            </td>
            <td>{{ $promo->percent_discount }}</td>
            <td data-service-ids="{{ implode(',', $promo->services->pluck('service_id')->toArray()) }}">
              {{ implode(', ', $promo->services->pluck('service_name')->toArray()) }}
            </td>
            <td>{{ $promo->start_date->format('Y-m-d') }}</td>
            <td>{{ $promo->end_date->format('Y-m-d') }}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-promo-btn" data-id="{{ $promo->promo_id }}">Edit</button>
              <button class="btn btn-sm btn-danger delete-promo-btn" data-id="{{ $promo->promo_id }}">Delete</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Promo Modal -->
<div class="modal fade" id="addPromoModal" tabindex="-1" role="dialog" aria-labelledby="addPromoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPromoModalLabel">Add Promo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPromoForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="promo_name">Promo Name</label>
            <input type="text" class="form-control" id="promo_name" name="promo_name" required>
          </div>
          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
          </div>
          <div class="form-group">
            <label for="percent_discount">Discount (%)</label>
            <input type="number" class="form-control" id="percent_discount" name="percent_discount" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="service_id">Services</label>
            <select class="form-control" id="service_id" name="service_id[]" multiple required>
              @foreach ($services as $service)
                <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Promo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Promo Modal -->
<div class="modal fade" id="editPromoModal" tabindex="-1" role="dialog" aria-labelledby="editPromoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPromoModalLabel">Edit Promo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editPromoForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" id="edit_promo_id" name="promo_id">
          <div class="form-group">
            <label for="edit_promo_name">Promo Name</label>
            <input type="text" class="form-control" id="edit_promo_name" name="promo_name" required>
          </div>
          <div class="form-group">
            <label for="edit_image">Image</label>
            <input type="file" class="form-control-file" id="edit_image" name="image" accept="image/*">
            <img id="current_image" src="" alt="Current Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
          </div>
          <div class="form-group">
            <label for="edit_percent_discount">Discount (%)</label>
            <input type="number" class="form-control" id="edit_percent_discount" name="percent_discount" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="edit_service_id">Services</label>
            <select class="form-control" id="edit_service_id" name="service_id[]" multiple required>
              @foreach ($services as $service)
                <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="edit_start_date">Start Date</label>
            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
          </div>
          <div class="form-group">
            <label for="edit_end_date">End Date</label>
            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Promo</button>
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
        Are you sure you want to delete this promo? This action cannot be undone.
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
    // Add Promo
    $('.add-promo-btn').click(function() {
      $('#addPromoModal').modal('show');
    });

    $('#addPromoForm').submit(function(e) {
      e.preventDefault();
      addPromo();
    });

    function addPromo() {
      var formData = new FormData($('#addPromoForm')[0]);

      $.ajax({
        url: '/admin/promos',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#addPromoModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while adding the promo.');
        }
      });
    }

    // Edit Promo
    $('.edit-promo-btn').click(function() {
      var id = $(this).data('id');
      var row = $(this).closest('tr');
      var name = row.find('td:eq(0)').text();
      var discount = row.find('td:eq(2)').text();
      var serviceIds = row.find('td:eq(3)').data('service-ids').split(',');
      var startDate = row.find('td:eq(4)').text();
      var endDate = row.find('td:eq(5)').text();
      var imageSrc = row.find('img').attr('src');

      $('#edit_promo_id').val(id);
      $('#edit_promo_name').val(name);
      $('#edit_percent_discount').val(discount);
      $('#edit_service_id').val(serviceIds);
      $('#edit_start_date').val(startDate);
      $('#edit_end_date').val(endDate);
      $('#current_image').attr('src', imageSrc);

      $('#editPromoModal').modal('show');
    });

    $('#editPromoForm').submit(function(e) {
      e.preventDefault();
      updatePromo();
    });

    function updatePromo() {
      var formData = new FormData($('#editPromoForm')[0]);
      var promoId = $('#edit_promo_id').val();

      $.ajax({
        url: '/admin/promos/' + promoId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $('#editPromoModal').modal('hide');
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('An error occurred while updating the promo.');
        }
      });
    }

    // Delete Promo
    let deleteId;
    $('.delete-promo-btn').click(function() {
      deleteId = $(this).data('id');
      $('#deleteConfirmModal').modal('show');
    });

    $('#confirmDelete').click(deletePromo);

    function deletePromo() {
      $.ajax({
        url: '/admin/promos/' + deleteId,
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
          alert('An error occurred while deleting the promo.');
          $('#deleteConfirmModal').modal('hide');
        }
      });
    }
  });
</script>
@endsection