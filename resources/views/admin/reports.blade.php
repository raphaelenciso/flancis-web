@extends('layouts.admin')

@section('title', 'Admin Reports')

@section('content')
<!-- Begin Page Content -->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Reports</h1>
  <div class="d-flex">
    <div class="dropdown no-arrow mr-2">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Period
      </button>
      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#" onclick="updateChart('weekly')">Weekly</a>
        <a class="dropdown-item" href="#" onclick="updateChart('monthly')">Monthly</a>
        <a class="dropdown-item" href="#" onclick="updateChart('yearly')">Yearly</a>
      </div>
    </div>
    <div class="dropdown no-arrow">
      <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Export Report
      </button>
      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="exportDropdownButton">
        <a class="dropdown-item" href="/admin/reports/export/weekly">Weekly</a>
        <a class="dropdown-item" href="/admin/reports/export/monthly">Monthly</a>
        <a class="dropdown-item" href="/admin/reports/export/yearly">Yearly</a>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
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
      <div class="card-body" id="topServicesContainer">
        <!-- Top services will be loaded here via AJAX -->
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
    var topServicesContainer = $("#topServicesContainer");

    var earningsChart;
    var revenueSourcesChart;

    function fetchReportData(period = 'yearly') {
      $.ajax({
        url: `/admin/reports/data/${period}`,
        method: "GET",
        success: function(response) {
          var earningsData = response.monthlyData; // {labels, data}
          var topServices = response.topServices; // [{service_id, name, avg_rating, rating_count}]
          var serviceTypeData = response.serviceTypeRevenue; // [{service_type_id, service_type, appointment_count}]

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

          // Destroy existing charts if they exist
          if (earningsChart) {
            earningsChart.destroy();
          }
          if (revenueSourcesChart) {
            revenueSourcesChart.destroy();
          }

          // Create new charts
          earningsChart = createAreaChart(ctxEarnings, earningsData.labels, earningsData.data);
          revenueSourcesChart = createPieChart(ctxRevenueSources, pieData);

          // Render top services
          topServicesContainer.empty();
          var colors = ['danger', 'success', 'warning', 'info', 'primary'];
          var colorIndex = 0;

          topServices.forEach(function(service) {
            var name = service.name;
            var rating = Math.round(service.avg_rating * 10) / 10;
            var ratingCount = service.rating_count;
            var color = colors[colorIndex % colors.length];
            var width = rating * 20;

            var fullStars = Math.floor(rating);
            var halfStar = rating - fullStars >= 0.5 ? 1 : 0;
            var emptyStars = 5 - fullStars - halfStar;

            var stars = '<i class="fas fa-star text-warning"></i>'.repeat(fullStars);
            stars += halfStar ? '<i class="fas fa-star-half-alt text-warning"></i>' : '';
            stars += '<i class="far fa-star text-warning"></i>'.repeat(emptyStars);

            var serviceHtml = `
              <h4 class="small font-weight-bold text-${color}">
                ${name} <span class="float-right">${stars} (${rating}) - ${ratingCount} ratings</span>
              </h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-${color}" role="progressbar" style="width: ${width}%"
                  aria-valuenow="${width}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            `;

            topServicesContainer.append(serviceHtml);
            colorIndex++;
          });
        }
      });
    }

    // Fetch initial data for the default period (yearly)
    fetchReportData();

    // Update the charts based on the selected period (weekly, monthly, yearly)
    window.updateChart = function(period) {
      fetchReportData(period);
    };
  });
</script>
@endsection