<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Reminder</title>
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
      <h1>Appointment Reminder</h1>
    </div>
    <div class="content">
      <p>Dear {{ $appointment->user->first_name }},</p>

      <p>This is a friendly reminder that your appointment is coming up in {{ $timeFrame }}. Here are the details:</p>

      <ul>
        <li><strong>Appointment ID:</strong> {{ $appointment->appointment_id }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</li>
        <li><strong>Service:</strong> {{ $appointment->service->service_name }}</li>
      </ul>

      <p>We look forward to seeing you soon!</p>

      <p>If you need to reschedule or have any questions, please contact us as soon as possible.</p>
    </div>
    <div class="footer">
      <p>This is an automated reminder. Please do not reply to this email.</p>
    </div>
  </div>
</body>

</html>