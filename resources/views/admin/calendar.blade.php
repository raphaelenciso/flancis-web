@extends('layouts.admin')


@section('content')

  <h1 class="h3 mb-2 text-gray-800">Appointment Calendar</h1>
  <p class="mb-4">View confirmed appointments on the calendar.</p>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div id="calendar"></div>
    </div>
  </div>


@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
<script>
  $(document).ready(function() {
    var events = @json($events);
    console.log('Events data:', events);

    var calendarEl = $('#calendar');
    var calendar = new FullCalendar.Calendar(calendarEl[0], {
      initialView: 'dayGridMonth',
      events: events
    });

    calendar.render();
  });
</script>
@endsection