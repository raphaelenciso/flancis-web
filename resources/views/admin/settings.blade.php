@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Settings</h1>

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <div class="row">
    @foreach (['gcash', 'landbank', 'bdo'] as $type)
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-header">
          {{ ucfirst($type) }} QR Code
        </div>
        <div class="card-body">
          @if (isset($paymentOptions[$type]))
          <img src="{{ asset('images/payment-options/' . $paymentOptions[$type]) }}" alt="{{ $type }} QR Code" class="img-fluid mb-3">
          <form action="{{ url('/admin/settings/remove-qr') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="type" value="{{ $type }}">
            <button type="submit" class="btn btn-danger btn-block">Remove QR Code</button>
          </form>
          @else
          <p>No QR code uploaded yet.</p>
          <form action="{{ url('/admin/settings/upload-qr') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="form-group">
              <input type="file" name="qr_image" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Upload QR Code</button>
          </form>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection