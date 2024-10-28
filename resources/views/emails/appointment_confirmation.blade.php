<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
<h2>Appointment Confirmation</h2>
<p>Dear {{ $appointment->patient->first_name }},</p>
<p>Your appointment has been successfully scheduled with Dr. {{ $appointment->doctor->name }} on {{ $appointment->appointment_date }} from {{ $appointment->start_time }} to {{ $appointment->end_time }}.</p>
<p>Thank you for choosing our service!</p>
</body>
</html>
