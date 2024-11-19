@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@php
if (!function_exists('getStatusClass')) {
function getStatusClass($status) {
switch ($status) {
case 'confirmed':
return 'success';
case 'pending':
return 'warning';
case 'rejected':
case 'cancelled':
return 'danger';
case 'completed':
return 'info';
default:
return 'secondary';
}
}
}
@endphp

@section('styles')
<style>
  /* Calendar container adjustments */
  #dashboardCalendar {
    font-size: 0.85rem;
    margin: 1rem;
  }

  /* Header toolbar adjustments */
  .fc .fc-toolbar {
    flex-wrap: wrap;
    gap: 0.3rem;
  }

  /* Significantly reduce month/year title size */
  .fc .fc-toolbar-title {
    font-size: 0.75rem !important;
    font-weight: 600;
  }

  /* Make buttons even smaller */
  .fc .fc-button {
    padding: 0.15rem 0.3rem !important;
    font-size: 0.65rem !important;
    line-height: 1 !important;
  }

  /* Today button specific - match other buttons */
  .fc .fc-today-button {
    font-size: 0.65rem !important;
    padding: 0.15rem 0.3rem !important;
  }

  /* Date cell adjustments */
  .fc .fc-daygrid-day {
    min-height: 2rem !important;
  }

  .fc .fc-daygrid-day-number {
    font-size: 0.85rem;
    padding: 0.25rem;
  }

  /* Event text adjustments */
  .fc .fc-event-title {
    font-size: 0.75rem;
  }

  /* Ensure header alignment */
  .fc .fc-header-toolbar {
    margin-bottom: 0.5rem !important;
  }
</style>
@endsection

@section('content')
<!-- Begin Page Content -->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
  </a>
</div>

<!-- Content Row -->
<div class="row">
  <!-- Total Appointments Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
              Appointments (Last 24h)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ $totalAppointments }} Appointments
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Customers Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              New Customers (Last 24h)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ $totalCustomers }} Customers
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Sales Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
              Sales (Last 24h)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              ₱{{ number_format($totalSales, 2) }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-money-bill fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Employees Card -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
              Total Employees</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ $totalEmployees }} Employees
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row">
  <!-- Left Column -->
  <div class="col-xl-8 col-lg-7">
    <!-- Today's Appointments -->

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Today's Appointments</h6>
      </div>
      <div class="card-body" style="max-height: 320px; overflow-y: auto;">
        <div class="appointment-list">
          @forelse($todayAppointments as $appointment)
          <div class="card mb-3">
            <div class="card-body py-2">
              <a href="{{ url('/admin/appointments') }}" class="text-decoration-none text-reset">
                <div class="row no-gutters align-items-center">
                  <div class="col-auto mr-2">
                    <img src="{{ $appointment->user->picture ?  asset("images/customer-pictures/" . $appointment->user->picture) : asset('images/user-placeholder.png') }}"
                      class="rounded-circle" width="40" height="40"
                      alt="{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}">
                  </div>
                  <div class="col">
                    <h6 class="mb-0">
                      {{ $appointment->user->first_name }}
                      {{ $appointment->user->middle_name ? $appointment->user->middle_name . ' ' : '' }}
                      {{ $appointment->user->last_name }}
                    </h6>
                    <small class="text-muted">
                      {{ $appointment->service->service_name }} at {{ $appointment->appointment_time->format('g:i A') }}
                    </small>
                  </div>
                  <div class="col-auto">
                    <span class="badge badge-{{ getStatusClass($appointment->status) }}">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </div>
                </div>
              </a>
            </div>
          </div>
          @empty
          <p class="text-center">No appointments for today.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Top Services and Revenue Sources Row -->
    <div class="row">
      <!-- Earnings Overview Card -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="myAreaChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Revenue Sources Card -->
      <!-- <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
          </div>
          <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
              <canvas id="myPieChart"></canvas>
            </div>
          </div>
        </div>
      </div> -->

      <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4 h-100">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top Services</h6>
          </div>
          <div class="card-body">
            @php
            $colors = ['danger', 'success', 'warning', 'info', 'primary'];
            $colorIndex = 0;
            @endphp
            @foreach($topServices->take(4) as $service)
            @php
            $name = $service->name;
            $rating = round($service->avg_rating, 1);
            $ratingCount = $service->rating_count;
            $color = $colors[$colorIndex % count($colors)];
            $width = $rating * 20;

            $fullStars = floor($rating);
            $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
            $emptyStars = 5 - $fullStars - $halfStar;

            $stars = str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
            $stars .= $halfStar ? '<i class="fas fa-star-half-alt text-warning"></i>' : '';
            $stars .= str_repeat('<i class="far fa-star text-warning"></i>', $emptyStars);

            $colorIndex++;
            @endphp
            <h4 class="small font-weight-bold text-{{ $color }}">
              {{ $name }} <span class="float-right">{!! $stars !!} ({{ $rating }}) - {{ $ratingCount }} ratings</span>
            </h4>
            <div class="progress mb-4">
              <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $width }}%"
                aria-valuenow="{{ $width }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column -->
  <div class="col-xl-4 col-lg-5">
    <!-- Calendar Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Appointment Calendar</h6>
      </div>
      <div class="card-body">
        <div id="dashboardCalendar"></div>
      </div>
    </div>
  </div>
</div>

<!-- /.container-fluid -->
@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

<!-- Add FullCalendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = $("#myAreaChart");
    var monthlyData = @json(array_values($monthlyData));
    var myLineChart = createAreaChart(ctx, undefined, monthlyData);

    var serviceTypeData = @json($serviceTypeRevenue);
    var labels = serviceTypeData.map(item => item.service_type);
    var data = serviceTypeData.map(item => item.appointment_count);

    // Generate colors based on the number of service types
    var colors = generateColors(serviceTypeData.length);

    var pieData = {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: colors,
        hoverBackgroundColor: colors.map(color => LightenDarkenColor(color, -20)),
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    };

    var ctx2 = $("#myPieChart");
    var myPieChart = createPieChart(ctx2, pieData);

    // Initialize Calendar
    var calendarEl = document.getElementById('dashboardCalendar');
    if (calendarEl) {
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 480,
        headerToolbar: {
          left: 'title',
          center: '',
          right: 'prev,next'
        },
        buttonText: {
          today: 'Today'
        },
        events: @json($events),
        dayMaxEvents: 2,
        eventDisplay: 'block',
        displayEventTime: false,
        firstDay: 0,
        handleWindowResize: true,
        // contentHeight: 'auto'
      });

      calendar.render();
    }
  });
</script>
@endsection