@extends('layouts.admin')

@section('title', 'Admin Reports')

@section('content')
<!-- Begin Page Content -->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Reports</h1>
  <a href="{{ route('admin.reports.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Export Report
  </a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
        <div class="dropdown no-arrow">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Select Period
          </button>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#" onclick="updateChart('weekly')">Weekly</a>
            <a class="dropdown-item" href="#" onclick="updateChart('monthly')">Monthly</a>
            <a class="dropdown-item" href="#" onclick="updateChart('yearly')">Yearly</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="earningsOverviewChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row">
  <!-- Top Services Card -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow h-100">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Top Services</h6>
      </div>
      <div class="card-body">
        @php
        $colors = ['danger', 'success', 'warning', 'info', 'primary'];
        $colorIndex = 0;
        @endphp
        @foreach($topServices as $service)
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

  <!-- Revenue Sources Card -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
      </div>
      <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
          <canvas id="revenueSourcesChart"></canvas>
        </div>
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

<script>
  $(document).ready(function() {
    var ctxEarnings = $("#earningsOverviewChart");
    var ctxRevenueSources = $("#revenueSourcesChart");

    var earningsData = @json(array_values($monthlyData));
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

    var earningsChart = createAreaChart(ctxEarnings, earningsData);
    var revenueSourcesChart = createPieChart(ctxRevenueSources, pieData);

    window.updateChart = function(period) {
      // Update the charts based on the selected period (weekly, monthly, yearly)
      // This is a placeholder function. You need to implement the logic to fetch and update the data.
      console.log('Update chart for period:', period);
    };
  });
</script>
@endsection