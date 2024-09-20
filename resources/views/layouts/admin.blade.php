@php
if (!Auth::check() || Auth::user()->role !== 'admin') {
header("Location: /signin");
exit();
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Flanci\'s Admin')</title>

  <!-- Custom fonts for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Start of Sidebar  -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin/dashboard">
        <div class="sidebar-brand-icon">
          <img src="{{ asset('images/logo-transparent.png') }}" alt="Flanci's Admin Logo" width="80" height="80" class="img-fluid">
        </div>
        <div class="sidebar-brand-text mx-3">Flanci's Admin</div>
      </a>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Nav Item - Appointment Collapse Menu -->
      <li class="nav-item {{ Request::is('admin/appointments*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/appointments">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Appointments</span>
        </a>
      </li>

      <!-- Add this new item for Calendar -->
      <li class="nav-item {{ Request::is('admin/calendar') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/calendar">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span>Calendar</span>
        </a>
      </li>

      <!-- Nav Item - Services Collapse Menu -->
      <li class="nav-item {{ Request::is('admin/services*') || Request::is('admin/service-types*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/services*') || Request::is('admin/service-types*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseServices" aria-expanded="{{ Request::is('admin/services*') || Request::is('admin/service-types*') ? 'true' : 'false' }}" aria-controls="collapseServices">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Services</span>
        </a>
        <div id="collapseServices" class="collapse {{ Request::is('admin/services*') || Request::is('admin/service-types*') ? 'show' : '' }}" aria-labelledby="headingServices" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Request::is('admin/services') ? 'active' : '' }}" href="/admin/services">All Services</a>
            <a class="collapse-item {{ Request::is('admin/service-types') ? 'active' : '' }}" href="/admin/service-types">Service Types</a>
          </div>
        </div>
      </li>

      <!-- Add this new item -->
      <li class="nav-item {{ Request::is('admin/resources*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/resources">
          <i class="fas fa-fw fa-boxes"></i>
          <span>Resources</span>
        </a>
      </li>

      <!-- Nav Item - Customer Collapse Menu -->
      <li class="nav-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/customers">
          <i class="fas fa-fw fa-users"></i>
          <span>Customers</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/employees*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/employees">
          <i class="fas fa-fw fa-user-tie"></i>
          <span>Employees</span>
        </a>
      </li>

      <li class="nav-item {{ Request::is('admin/ratings*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/ratings">
          <i class="fas fa-fw fa-star"></i>
          <span>Ratings</span>
        </a>
      </li>

      <!-- Add this new item in the sidebar -->
      <li class="nav-item {{ Request::is('admin/promos*') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/promos">
          <i class="fas fa-fw fa-percent"></i>
          <span>Promos</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar  -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Start of Topbar -->
      <nav
        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
        <button
          id="sidebarToggleTop"
          class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Nav Item - Search Dropdown (Visible Only XS) -->
          <li class="nav-item dropdown no-arrow d-sm-none">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="searchDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
            </a>

          </li>

          <!-- Nav Item - Notifications -->

          <li class="nav-item dropdown no-arrow mx-1">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="notificationsDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <i class="fas fa-bell fa-fw"></i>
              <!-- Counter - Notifications -->
              <span class="badge badge-danger badge-counter">{{ Auth::user()->unreadNotifications()->count() }}</span>
            </a>
            <!-- Dropdown - Notifications -->
            <div
              class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
              aria-labelledby="notificationsDropdown">
              <h6 class="dropdown-header">Notifications Center</h6>
              @forelse(Auth::user()->unreadNotifications as $notification)
              <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('mark-as-read-{{ $notification->notification_id }}').submit();">
                <div class="mr-3">
                  <div class="icon-circle bg-primary">
                    <i class="fas fa-file-alt text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500">{{ $notification->created_at->format('F d, Y') }}</div>
                  <div class="{{ !$notification->is_read ? 'font-weight-bold' : '' }}">{{ $notification->message }}</div>
                </div>
              </a>
              <form id="mark-as-read-{{ $notification->notification_id }}" action="/admin/notifications/mark-as-read" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="notification_id" value="{{ $notification->notification_id }}">
              </form>
              @empty
              <a class="dropdown-item text-center small text-gray-500" href="#">No new notifications</a>
              @endforelse

            </div>
          </li>



          <div class="topbar-divider d-none d-sm-block"></div>

          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="userDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false">
              <img
                class="img-profile rounded-circle"
                src="{{ Auth::user()->picture ? asset('images/customer-pictures/' . Auth::user()->picture) : asset('images/user-placeholder.png') }}" />
            </a>
            <!-- Dropdown - User Information -->
            <div
              class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
              aria-labelledby="userDropdown">
              <a
                class="dropdown-item"
                href="#"
                data-toggle="modal"
                data-target="#logoutModal">
                <i
                  class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <!-- End of Topbar  -->

      <!-- Main Content -->
      <div id="content">
        <div class="container-fluid">
          <!-- Begin Page Content -->
          @yield('content')
          <!-- End Page Content -->
        </div>
        <!-- End of Main Content -->
      </div>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Logout Modal-->
  <div
    class="modal fade"
    id="logoutModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button
            class="close"
            type="button"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-secondary"
            type="button"
            data-dismiss="modal">
            Cancel
          </button>
          <form action="/logout" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- DataTables JavaScript -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')  }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  @yield('scripts')


</body>

</html>