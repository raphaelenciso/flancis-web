<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
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
            <h1>Appointment Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $appointment->user->name }},</p>
            
            <p>Thank you for booking an appointment with us. Your appointment details are as follows:</p>
            
            <ul>
                <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</li>
                <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</li>
                <li><strong>Service:</strong> {{ $appointment->service->service_name }}</li>
                <li><strong>Payment Type:</strong> {{ ucfirst($appointment->payment_type) }}</li>
            </ul>
            
            <p>Your appointment is currently pending and will be confirmed once payment is verified.</p>
            
            <p>If you need to reschedule or have any questions, please contact us.</p>
            
            <p>We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>