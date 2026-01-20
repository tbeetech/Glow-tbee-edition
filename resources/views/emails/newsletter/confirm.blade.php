<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm subscription</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <p>Thanks for subscribing to the Glow FM newsletter.</p>
    <p>Please confirm your subscription by clicking the button below:</p>
    <p>
        <a href="{{ $confirmUrl }}" style="display:inline-block;padding:10px 18px;background:#059669;color:#fff;text-decoration:none;border-radius:6px;">
            Confirm subscription
        </a>
    </p>
    <p>If you wish to unsubscribe, click here:</p>
    <p><a href="{{ $unsubscribeUrl }}">{{ $unsubscribeUrl }}</a></p>
    <p>If you did not request this, you can safely ignore this email.</p>
</body>
</html>
