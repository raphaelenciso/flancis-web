<div class="table-responsive">
  <table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>Appointment ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Time</th>
        <th>Service</th>
        <th>Price</th>
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
        <td>
          @if ($appointment->promo)
          <span class="price-with-promo"><s>₱{{ number_format($appointment->service->price, 2) }}</s></span>
          <span class="text-success font-weight-bold">₱{{ number_format($appointment->price, 2) }}</span>
          @else
          ₱{{ number_format($appointment->price, 2) }}
          @endif
        </td>
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