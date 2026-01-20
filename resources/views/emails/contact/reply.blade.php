<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow FM Reply</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <p>Hi {{ $recipientName }},</p>
    <p>{!! nl2br(e($replyBody)) !!}</p>
    <p>Thanks,<br>Glow FM Team</p>
</body>
</html>
