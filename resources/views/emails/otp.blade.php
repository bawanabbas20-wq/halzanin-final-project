<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your verification code — {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background:#EFEDE8;font-family:'Outfit',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#EFEDE8;padding:40px 16px;">
  <tr><td align="center">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

      {{-- Logo header --}}
      <tr>
        <td align="center" style="padding-bottom:24px;">
          <img src="{{ url('images/halzanin-logo.png') }}" alt="{{ config('app.name') }}" height="56" style="height:56px;width:auto;display:block;">
        </td>
      </tr>

      {{-- Card --}}
      <tr>
        <td style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(27,79,138,0.10);">

          {{-- Blue top bar --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="background:linear-gradient(135deg,#1B4F8A 0%,#2563a8 100%);padding:32px 40px 28px;text-align:center;">
                <p style="margin:0;font-size:13px;color:rgba(255,255,255,0.75);text-transform:uppercase;letter-spacing:2px;font-weight:600;">Email Verification</p>
                <h1 style="margin:8px 0 0;font-size:26px;font-weight:800;color:#ffffff;">Verify your account</h1>
              </td>
            </tr>
          </table>

          {{-- Body --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding:36px 40px;">
                <p style="margin:0 0 8px;font-size:16px;color:#374151;">Hi <strong style="color:#111111;">{{ $user->name }}</strong>,</p>
                <p style="margin:0 0 28px;font-size:15px;color:#6b7280;line-height:1.6;">
                  Use the code below to complete your registration on <strong style="color:#1B4F8A;">{{ config('app.name') }}</strong>. This code expires in <strong>10 minutes</strong>.
                </p>

                {{-- OTP Box --}}
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" style="background:#EFF4FB;border:2px dashed #1B4F8A;border-radius:12px;padding:28px 20px;">
                      <p style="margin:0 0 6px;font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:2px;font-weight:600;">Your verification code</p>
                      <p style="margin:0;font-size:48px;font-weight:800;color:#1B4F8A;letter-spacing:14px;line-height:1.1;">{{ $otp }}</p>
                      <p style="margin:10px 0 0;font-size:12px;color:#9ca3af;">Expires in 10 minutes</p>
                    </td>
                  </tr>
                </table>

                <p style="margin:28px 0 0;font-size:13px;color:#9ca3af;line-height:1.6;">
                  If you didn't create an account with {{ config('app.name') }}, you can safely ignore this email.
                </p>
              </td>
            </tr>
          </table>

          {{-- Divider --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr><td style="border-top:1px solid #f0ede8;"></td></tr>
          </table>

          {{-- Footer inside card --}}
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding:20px 40px;text-align:center;">
                <p style="margin:0;font-size:12px;color:#9ca3af;">
                  © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                  This is an automated message — please do not reply.
                </p>
              </td>
            </tr>
          </table>

        </td>
      </tr>

      {{-- Bottom spacer --}}
      <tr><td style="height:32px;"></td></tr>

    </table>
  </td></tr>
</table>

</body>
</html>
