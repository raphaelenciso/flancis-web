<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Appointment Assigned</title>
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
      <h1>New Appointment Assigned</h1>
    </div>
    <div class="content">
      <p>Dear {{ $appointment->employee->employee_first_name }},</p>

      <p>A new appointment has been assigned to you. Here are the details:</p>

      <ul>
        <li><strong>Appointment ID:</strong> {{ $appointment->appointment_id }}</li>
        <li><strong>Customer:</strong> {{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</li>
        <li><strong>Service:</strong> {{ $appointment->service->service_name }}</li>
      </ul>

      <p>Please ensure you're prepared for this appointment. If you have any questions or concerns, please contact the admin.</p>
    </div>
    <div class="footer">
      <p>This is an automated message. Please do not reply to this email.</p>
    </div>
  </div>
</body>

</html>