<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Receipt - {{ $application->tracking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            text-align: center;
            padding: 40px;
        }
        .header {
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .value {
            font-size: 18px;
            font-weight: bold;
        }
        .tracking-code {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5; /* Indigo */
            letter-spacing: 2px;
        }
        .qr-container {
            margin: 30px 0;
            padding: 15px;
            border: 1px solid #ddd;
            display: inline-block;
            background: #fff;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">Application Receipt</div>
    </div>

    <div class="field">
        <div class="label">Applicant Name</div>
        <div class="value">{{ $application->appointment->full_name ?? $application->user->name }}</div>
    </div>

    <div class="field">
        <div class="label">Tracking Code</div>
        <div class="tracking-code">{{ $application->tracking_code }}</div>
    </div>

    <div class="qr-container">
        <!-- Embed Base64 QR Image -->
        <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
    </div>

    <div class="footer">
        <p>Submitted on: {{ $application->submitted_at->format('M d, Y h:i A') }}</p>
        <p>Keep this document safe. Scan the QR code to track your application status.</p>
    </div>

</body>
</html>
