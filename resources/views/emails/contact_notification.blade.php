<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {{ $messageData['name'] }}</p>
    <p><strong>Email:</strong> {{ $messageData['email'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $messageData['description'] }}</p>
</body>
</html>
