<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Birthday</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <div style="max-width: 600px; margin: 0 auto;">
        <div style="padding: 24px; border: 1px solid #e5e7eb; border-radius: 12px;">
            <p style="font-size: 16px; margin: 0 0 16px 0;">{!! nl2br(e($messageBody)) !!}</p>
            <p style="font-size: 14px; color: #6b7280; margin-top: 24px;">
                {{ $stationName }}
                @if($stationFrequency)
                    · {{ $stationFrequency }}
                @endif
            </p>
        </div>
    </div>
</body>
</html>
