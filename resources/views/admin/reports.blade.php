@extends('layouts.admin')

@section('title', 'Admin Reports')

@section('content')
<!-- Begin Page Content -->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Reports</h1>
  <div class="d-flex">
    <div class="dropdown no-arrow">
      <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Export Report
      </button>
      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="exportDropdownButton">
        <a class="dropdown-item" href="{{ url('admin/reports/export/weekly') }}">Weekly</a>
        <a class="dropdown-item" href="{{ url('admin/reports/export/monthly') }}">Monthly</a>
        <a class="dropdown-item" href="{{ url('admin/reports/export/yearly') }}">Yearly</a>
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
        <div class="d-flex align-items-center">
          <ul class="nav nav-tabs card-header-tabs mr-3" id="earningsTab">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#" data-period="yearly">Yearly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="monthly">Monthly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="weekly">Weekly</a>
            </li>
          </ul>
          <button class="btn btn-sm btn-primary" id="saveEarningsChart">Save as PNG</button>
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
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Top Services</h6>
        <div class="d-flex align-items-center">
          <ul class="nav nav-tabs card-header-tabs mr-3" id="topServicesTab">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#" data-period="yearly">Yearly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="monthly">Monthly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="weekly">Weekly</a>
            </li>
          </ul>
          <button class="btn btn-sm btn-primary" id="saveTopServices">Save as PNG</button>
        </div>
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
        <div class="d-flex align-items-center">
          <ul class="nav nav-tabs card-header-tabs mr-3" id="revenueSourcesTab">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#" data-period="yearly">Yearly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="monthly">Monthly</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#" data-period="weekly">Weekly</a>
            </li>
          </ul>
          <button class="btn btn-sm btn-primary" id="saveRevenueSourcesChart">Save as PNG</button>
        </div>
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

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
  $(document).ready(function() {
    var ctxEarnings = $("#earningsOverviewChart");
    var ctxRevenueSources = $("#revenueSourcesChart");
    var topServicesContainer = $("#topServicesContainer");

    var earningsChart;
    var revenueSourcesChart;

    function fetchReportData(section, period = 'yearly') {
      $.ajax({
        url: "{{ route('admin.reports.data', ['period' => '']) }}/" + period,
        method: "GET",
        success: function(response) {
          switch (section) {
            case 'earnings':
              updateEarningsChart(response.earningsData);
              break;
            case 'topServices':
              renderTopServices(response.topServices);
              break;
            case 'revenueSources':
              updateRevenueSourcesChart(response.serviceTypeRevenue);
              break;
          }
        }
      });
    }

    function updateEarningsChart(earningsData) {
      if (earningsChart) {
        earningsChart.destroy();
      }
      earningsChart = createAreaChart(ctxEarnings, earningsData.labels, earningsData.data);
    }

    function updateRevenueSourcesChart(serviceTypeData) {
      var labels = serviceTypeData.map(item => item.service_type);
      var data = serviceTypeData.map(item => item.appointment_count);
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

      if (revenueSourcesChart) {
        revenueSourcesChart.destroy();
      }
      revenueSourcesChart = createPieChart(ctxRevenueSources, pieData);
    }

    function renderTopServices(topServices) {
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

    // Fetch initial data for all sections (yearly)
    fetchReportData('earnings');
    fetchReportData('topServices');
    fetchReportData('revenueSources');

    // Handle tab clicks for each section
    $('#earningsTab .nav-link').on('click', function(e) {
      e.preventDefault();
      $('#earningsTab .nav-link').removeClass('active');
      $(this).addClass('active');
      var period = $(this).data('period');
      fetchReportData('earnings', period);
    });

    $('#topServicesTab .nav-link').on('click', function(e) {
      e.preventDefault();
      $('#topServicesTab .nav-link').removeClass('active');
      $(this).addClass('active');
      var period = $(this).data('period');
      fetchReportData('topServices', period);
    });

    $('#revenueSourcesTab .nav-link').on('click', function(e) {
      e.preventDefault();
      $('#revenueSourcesTab .nav-link').removeClass('active');
      $(this).addClass('active');
      var period = $(this).data('period');
      fetchReportData('revenueSources', period);
    });

    // Save as PNG functionality
    function saveAsPNG(elementId, filename) {
      html2canvas(document.querySelector(elementId)).then(canvas => {
        var link = document.createElement('a');
        link.download = filename;
        link.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        link.click();
      });
    }

    $('#saveEarningsChart').on('click', function() {
      saveAsPNG('#earningsOverviewChart', 'earnings_overview.png');
    });

    $('#saveTopServices').on('click', function() {
      saveAsPNG('#topServicesContainer', 'top_services.png');
    });

    $('#saveRevenueSourcesChart').on('click', function() {
      saveAsPNG('#revenueSourcesChart', 'revenue_sources.png');
    });
  });
</script>
@endsection