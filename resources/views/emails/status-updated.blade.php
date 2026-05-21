<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application Status Update — {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background:#EFEDE8;font-family:'Outfit',Arial,sans-serif;">

@php
    $isApproved = $application->current_status === 'approved';
    $isRejected = $application->current_status === 'rejected';
    $statusLabel = ucwords(str_replace('_', ' ', $application->current_status));

    if ($isApproved) {
        $badgeBg    = '#d1fae5'; $badgeColor = '#065f46'; $accentColor = '#059669';
        $bannerBg   = 'linear-gradient(135deg,#065f46 0%,#059669 100%)';
        $icon       = '✓';
    } elseif ($isRejected) {
        $badgeBg    = '#fee2e2'; $badgeColor = '#991b1b'; $accentColor = '#dc2626';
        $bannerBg   = 'linear-gradient(135deg,#991b1b 0%,#dc2626 100%)';
        $icon       = '✕';
    } else {
        $badgeBg    = '#dbeafe'; $badgeColor = '#1d4ed8'; $accentColor = '#1B4F8A';
        $bannerBg   = 'linear-gradient(135deg,#1B4F8A 0%,#2563a8 100%)';
        $icon       = '→';
    }

    $applicantName = $application->appointment?->full_name ?? $application->user?->name ?? 'Applicant';
    $latestNote    = $application->statusLogs?->sortByDesc('created_at')->first()?->notes;
@endphp

<table width="100%" cellpadding="0" cellspacing="0" style="background:#EFEDE8;padding:40px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

      {{-- Logo --}}
      <tr>
        <td align="center" style="padding-bottom:24px;">
          <img src="{{ url('images/halzanin-logo.png') }}" alt="{{ config('app.name') }}" height="56" style="height:56px;width:auto;display:block;">
        </td>
      </tr>

      {{-- Card --}}
      <tr>
        <td style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(27,79,138,0.10);">

          {{-- Colored top banner --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="background:{{ $bannerBg }};padding:32px 40px 28px;text-align:center;">
                <div style="display:inline-block;width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,0.2);line-height:52px;font-size:24px;color:#fff;font-weight:800;margin-bottom:12px;">{{ $icon }}</div>
                <p style="margin:0;font-size:13px;color:rgba(255,255,255,0.75);text-transform:uppercase;letter-spacing:2px;font-weight:600;">Application Update</p>
                <h1 style="margin:8px 0 0;font-size:26px;font-weight:800;color:#ffffff;">Your application has been {{ $statusLabel }}</h1>
              </td>
            </tr>
          </table>

          {{-- Body --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding:36px 40px;">

                <p style="margin:0 0 24px;font-size:16px;color:#374151;">
                  Hi <strong style="color:#111111;">{{ $applicantName }}</strong>,
                </p>

                {{-- Tracking code block --}}
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                  <tr>
                    <td style="background:#F8F6F2;border-left:4px solid {{ $accentColor }};border-radius:0 8px 8px 0;padding:16px 20px;">
                      <p style="margin:0 0 2px;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:1.5px;font-weight:600;">Tracking Code</p>
                      <p style="margin:0;font-size:22px;font-weight:800;color:{{ $accentColor }};letter-spacing:3px;">{{ $application->tracking_code }}</p>
                    </td>
                  </tr>
                </table>

                {{-- Status badge --}}
                <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                  <tr>
                    <td style="background:{{ $badgeBg }};color:{{ $badgeColor }};padding:6px 18px;border-radius:999px;font-size:13px;font-weight:700;">
                      {{ $statusLabel }}
                    </td>
                  </tr>
                </table>

                @if($isRejected && $latestNote)
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                  <tr>
                    <td style="background:#fff5f5;border:1px solid #fecaca;border-radius:10px;padding:16px 20px;">
                      <p style="margin:0 0 4px;font-size:12px;color:#dc2626;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Reason for Rejection</p>
                      <p style="margin:0;font-size:14px;color:#374151;line-height:1.6;">{{ $latestNote }}</p>
                    </td>
                  </tr>
                </table>
                @endif

                <p style="margin:0 0 28px;font-size:15px;color:#6b7280;line-height:1.6;">
                  You can track the full history of your application at any time — no login required.
                </p>

                {{-- CTA Button --}}
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="background:#1B4F8A;border-radius:10px;">
                      <a href="{{ url('/track/' . $application->tracking_code) }}"
                         style="display:inline-block;padding:14px 32px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;letter-spacing:0.3px;">
                        Track My Application →
                      </a>
                    </td>
                  </tr>
                </table>

                <p style="margin:28px 0 0;font-size:12px;color:#9ca3af;line-height:1.6;">
                  If the button doesn't work, copy this link into your browser:<br>
                  <span style="color:#1B4F8A;">{{ url('/track/' . $application->tracking_code) }}</span>
                </p>

              </td>
            </tr>
          </table>

          {{-- Divider --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr><td style="border-top:1px solid #f0ede8;"></td></tr>
          </table>

          {{-- Footer --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding:20px 40px;text-align:center;">
                <p style="margin:0;font-size:12px;color:#9ca3af;">
                  © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                  This is an automated notification — please do not reply to this email.
                </p>
              </td>
            </tr>
          </table>

        </td>
      </tr>

      <tr><td style="height:32px;"></td></tr>

    </table>
  </td></tr>
</table>

</body>
</html>
