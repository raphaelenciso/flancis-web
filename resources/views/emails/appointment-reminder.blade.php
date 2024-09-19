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
            background-color: #f4f4f4;
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
            <p>Dear {{ $appointment->user->name }},</p>
            
            <p>This is a friendly reminder about your upcoming appointment:</p>
            
            <ul>
                <li><strong>Date:</strong> {{ $appointment->appointment_date }}</li>
                <li><strong>Time:</strong> {{ $appointment->appointment_time }}</li>
                <li><strong>Service:</strong> {{ $appointment->service->name }}</li>
            </ul>
            
            <p>If you need to reschedule or have any questions, please contact us as soon as possible.</p>
            
            <p>We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>