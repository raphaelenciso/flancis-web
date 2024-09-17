@extends('layouts.customer')

@section('title', 'Book')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  @if(Auth::check())
  @php
  date_default_timezone_set('Asia/Manila');
  $hour = date('H');
  $greeting = 'Good evening';
  if ($hour >= 5 && $hour < 12) {
    $greeting='Good morning' ;
    } elseif ($hour>= 12 && $hour < 18) {
      $greeting='Good afternoon' ;
      }
      @endphp
      <h1 class="h3 mb-0 text-gray-800">{{ $greeting }}, {{ Auth::user()->username }}</h1>
      @endif
</div>

<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Book an Appointment</h6>
      </div>
      <div class="card-body">
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="/customer/book-appointment" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="appointment_date">Appointment Date</label>
            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
          </div>
          <div class="form-group">
            <label for="appointment_time">Appointment Time</label>
            <select class="form-control" id="appointment_time" name="appointment_time" required>
              <option value="">Select Time</option>
              @for($hour = 10; $hour <= 20; $hour++)
                @for($minute=0; $minute < 60; $minute +=30)
                @php
                $ampm=$hour>= 12 ? 'PM' : 'AM';
                $hour12 = $hour > 12 ? $hour - 12 : $hour;
                $time = sprintf("%02d:%02d %s", $hour12, $minute, $ampm);
                $value = sprintf("%02d:%02d", $hour, $minute);
                @endphp
                <option value="{{ $value }}">{{ $time }}</option>
                @endfor
                @endfor
            </select>
          </div>
          <div class="form-group">
            <label for="service_type_id">Service Type</label>
            <select class="form-control" id="service_type_id" name="service_type_id" required>
              <option value="">Select Service Type</option>
              @foreach($serviceTypes as $serviceType)
              <option value="{{ $serviceType->service_type_id }}">{{ $serviceType->service_type }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="service_id">Service</label>
            <select class="form-control" id="service_id" name="service_id" required>
              <option value="">Select Service</option>
            </select>
          </div>
          <div class="form-group">
            <label for="payment_type">Payment Type</label>
            <select class="form-control" id="payment_type" name="payment_type" required>
              <option value="">Select Payment Type</option>
              <option value="cash">Cash</option>
              <option value="gcash">GCash</option>
              <option value="bank_transfer">Bank Transfer</option>
            </select>
          </div>
          <div id="bank_options" style="display: none;">
            <div class="form-group">
              <label>Select Bank</label>
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-primary" onclick="showQRCode('bdo')">BDO</button>
                <button type="button" class="btn btn-outline-primary" onclick="showQRCode('landbank')">Land Bank</button>
              </div>
            </div>
          </div>
          <div id="qr_code_container" style="display: none;">
            <img id="qr_code_image" src="{{ asset('images/qr-codes/qrcode-placeholder.webp') }}" alt="Payment QR Code" class="img-fluid mb-3" style="max-width: 200px;">
          </div>
          <div class="form-group">
            <label for="proof">Proof of Payment (50% Deposit Required)</label>
            <input type="file" class="form-control-file" id="proof" name="proof" required accept="image/*">
          </div>
          <div class="form-group">
            <label for="remarks">Remarks (Optional)</label>
            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
          </div>
          <div class="alert alert-info" role="alert">
            <strong>Note:</strong> A 50% deposit is required to confirm your appointment.
          </div>
          <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var paymentTypeSelect = document.getElementById('payment_type');
    var bankOptions = document.getElementById('bank_options');
    var qrCodeContainer = document.getElementById('qr_code_container');
    var qrCodeImage = document.getElementById('qr_code_image');

    paymentTypeSelect.addEventListener('change', function() {
      if (this.value === 'bank_transfer') {
        bankOptions.style.display = 'block';
        qrCodeContainer.style.display = 'none';
      } else if (this.value === 'gcash') {
        bankOptions.style.display = 'none';
        qrCodeImage.src = '{{ asset("images/qr-codes/qrcode-placeholder.webp") }}';
        qrCodeContainer.style.display = 'block';
      } else {
        bankOptions.style.display = 'none';
        qrCodeContainer.style.display = 'none';
      }
    });

    var serviceTypeSelect = document.getElementById('service_type_id');
    var serviceSelect = document.getElementById('service_id');
    var services = @json($services);

    serviceTypeSelect.addEventListener('change', function() {
      var selectedServiceTypeId = this.value;
      serviceSelect.innerHTML = '<option value="">Select Service</option>';

      services.forEach(function(service) {
        if (service.service_type_id == selectedServiceTypeId) {
          var option = document.createElement('option');
          option.value = service.service_id;
          option.textContent = service.service_name;
          serviceSelect.appendChild(option);
        }
      });
    });
  });

  function showQRCode(bank) {
    var qrCodeImage = document.getElementById('qr_code_image');
    var qrCodeContainer = document.getElementById('qr_code_container');

    switch (bank) {
      case 'bdo':
        qrCodeImage.src = '{{ asset("images/qr-codes/qrcode-placeholder.webp") }}';
        break;
      case 'landbank':
        qrCodeImage.src = '{{ asset("images/qr-codes/qrcode-placeholder.webp") }}';
        break;
      default:
        qrCodeImage.src = '{{ asset("images/qr-codes/qrcode-placeholder.webp") }}';
    }

    qrCodeContainer.style.display = 'block';
  }
</script>
@endsection

@section('styles')
<style>
  select.form-control {
    color: #495057;
    background-color: #fff;
  }

  select.form-control option {
    color: #495057;
  }
</style>
@endsection