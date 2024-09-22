<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Status Update</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      background-color: #ad7c52;
      color: white;
      padding: 10px;
      text-align: center;
    }

    .content {
      padding: 20px 0;
    }

    .footer {
      text-align: center;
      font-size: 0.8em;
      color: #777;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Appointment Status Update</h1>
    </div>
    <div class="content">
      <p>Dear {{ $appointment->user->name }},</p>

      <p>The status of your appointment has been updated. Here are the current details:</p>

      <ul>
        <li><strong>Appointment ID:</strong> {{ $appointment->appointment_id }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</li>
        <li><strong>Service:</strong> {{ $appointment->service->service_name }}</li>
        <li><strong>New Status:</strong> {{ ucfirst($appointment->status) }}</li>
      </ul>

      @if($appointment->status == 'confirmed')
      <p>Your appointment has been confirmed. We look forward to seeing you!</p>
      @elseif($appointment->status == 'cancelled')
      <p>Your appointment has been cancelled. If you didn't request this cancellation, please contact us immediately.</p>
      @elseif($appointment->status == 'completed')
      <p>Your appointment has been marked as completed. We hope you enjoyed our service!</p>
      @elseif($appointment->status == 'rejected')
      <p>Unfortunately, your appointment has been rejected. If you have any questions, please contact us.</p>
      @endif

      @if($appointment->admin_note)
      <p><strong>Admin Note:</strong> {{ $appointment->admin_note }}</p>
      @endif

      <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
    </div>
    <div class="footer">
      <p>This is an automated message. Please do not reply to this email.</p>
    </div>
  </div>
</body>

</html>