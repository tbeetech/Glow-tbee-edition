<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <p>You received a new contact message.</p>
    <p><strong>Name:</strong> {{ $messageRecord->name }}</p>
    <p><strong>Email:</strong> {{ $messageRecord->email }}</p>
    <p><strong>Phone:</strong> {{ $messageRecord->phone ?? 'N/A' }}</p>
    <p><strong>Inquiry:</strong> {{ $messageRecord->inquiry_type ?? 'General' }}</p>
    <p><strong>Subject:</strong> {{ $messageRecord->subject }}</p>
    <p><strong>Message:</strong></p>
    <p>{!! nl2br(e($messageRecord->message)) !!}</p>
</body>
</html>
