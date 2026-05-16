<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #4f46e5; padding: 30px 40px; color: #fff; }
        .header h1 { margin: 0; font-size: 22px; }
        .body { padding: 30px 40px; color: #333; }
        .body p { line-height: 1.6; margin: 0 0 16px; }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            text-transform: capitalize;
            margin: 10px 0 20px;
        }
        .status-submitted  { background: #e5e7eb; color: #374151; }
        .status-received   { background: #dbeafe; color: #1d4ed8; }
        .status-under_review { background: #fef3c7; color: #92400e; }
        .status-approved   { background: #d1fae5; color: #065f46; }
        .status-rejected   { background: #fee2e2; color: #991b1b; }
        .tracking { font-size: 24px; font-weight: bold; color: #4f46e5; letter-spacing: 2px; margin: 10px 0 20px; }
        .cta { display: inline-block; background: #4f46e5; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 10px; }
        .footer { background: #f9fafb; padding: 20px 40px; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Application Status Update</h1>
        </div>
        <div class="body">
            <p>Dear <strong>{{ $application->appointment->full_name ?? $application->user->name }}</strong>,</p>
            <p>Your application status has been updated. Here are the details:</p>

            <p style="margin-bottom:4px; color:#6b7280; font-size:13px; text-transform:uppercase; letter-spacing:1px;">Tracking Code</p>
            <div class="tracking">{{ $application->tracking_code }}</div>

            <p style="margin-bottom:4px; color:#6b7280; font-size:13px; text-transform:uppercase; letter-spacing:1px;">New Status</p>
            <span class="status-badge status-{{ $application->current_status }}">
                {{ str_replace('_', ' ', $application->current_status) }}
            </span>

            <p>You can track the full history of your application at any time using the button below — no login required.</p>

            <a href="{{ url('/track/' . $application->tracking_code) }}" class="cta">Track My Application</a>
        </div>
        <div class="footer">
            <p>This is an automated notification from the Kurdistan Passport Directorate Document Tracking System. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
