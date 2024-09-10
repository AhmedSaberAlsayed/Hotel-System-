<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Booking Confirmation</h1>
    <p>Dear {{ $booking->guest->name }},</p>
    <p>Thank you for your booking at our hotel. Here are your booking details:</p>

    <ul>
        <li><strong>Room Number:</strong> {{ $booking->room->RoomNumber }}</li>
        <li><strong>Check-In Date:</strong> {{ $booking->CheckInDate }}</li>
        <li><strong>Check-Out Date:</strong> {{ $booking->CheckOutDate }}</li>
        <li><strong>Total Price:</strong> ${{ $booking->TotalPrice }}</li>
    </ul>

    <p>We look forward to your stay with us!</p>

    <p>Best Regards,<br>The Hotel Team</p>
</body>
</html>
