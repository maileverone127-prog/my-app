<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;-webkit-text-size-adjust:100%">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f3f4f6;padding:40px 16px">
<tr><td align="center">

    <table width="560" cellpadding="0" cellspacing="0" role="presentation"
           style="max-width:560px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 1px 8px rgba(0,0,0,.08)">

        {{-- ===== HEADER ===== --}}
        <tr>
            <td style="background:linear-gradient(135deg,#6366f1 0%,#4f46e5 100%);padding:32px 36px">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td>
                            <p style="margin:0 0 4px;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6)">
                                Portfolio Contact
                            </p>
                            <h1 style="margin:0;font-size:22px;font-weight:700;color:#ffffff;line-height:1.3">
                                New Message Received
                            </h1>
                        </td>
                        <td align="right" style="vertical-align:top">
                            <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:10px;display:inline-block;text-align:center;line-height:44px;font-size:22px">
                                ✉️
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:10px">
                            <p style="margin:0;font-size:12px;color:rgba(255,255,255,.65)">
                                {{ now()->format('l, d F Y \a\t g:i A') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- ===== SENDER INFO ===== --}}
        <tr>
            <td style="padding:28px 36px 0">
                <p style="margin:0 0 16px;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#9ca3af">
                    Sender Details
                </p>
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                       style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden">
                    <tr style="border-bottom:1px solid #e5e7eb">
                        <td style="padding:12px 16px;background:#f9fafb;width:80px">
                            <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em">Name</span>
                        </td>
                        <td style="padding:12px 16px;background:#ffffff">
                            <span style="font-size:14px;font-weight:600;color:#111827">{{ $contactMessage->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:12px 16px;background:#f9fafb">
                            <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.05em">Email</span>
                        </td>
                        <td style="padding:12px 16px;background:#ffffff">
                            <a href="mailto:{{ $contactMessage->email }}"
                               style="font-size:14px;color:#6366f1;text-decoration:none;font-weight:500">
                                {{ $contactMessage->email }}
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- ===== MESSAGE BODY ===== --}}
        <tr>
            <td style="padding:24px 36px 0">
                <p style="margin:0 0 10px;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#9ca3af">
                    Message
                </p>
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-left:4px solid #6366f1;border-radius:0 8px 8px 0;padding:20px">
                    <p style="margin:0;font-size:15px;color:#374151;line-height:1.75;white-space:pre-wrap">{{ $contactMessage->message }}</p>
                </div>
            </td>
        </tr>

        {{-- ===== ACTION BUTTONS ===== --}}
        <tr>
            <td style="padding:28px 36px">
                <table cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="padding-right:10px">
                            <a href="{{ rtrim(config('app.url'), '/') }}/admin/messages/{{ $contactMessage->id }}"
                               style="display:inline-block;background:#6366f1;color:#ffffff;text-decoration:none;padding:12px 22px;border-radius:8px;font-size:13px;font-weight:600;letter-spacing:.01em">
                                View in Admin Panel →
                            </a>
                        </td>
                        <td>
                            <a href="mailto:{{ $contactMessage->email }}?subject=Re: Your message to {{ config('app.name') }}"
                               style="display:inline-block;background:#f3f4f6;color:#374151;text-decoration:none;padding:12px 22px;border-radius:8px;font-size:13px;font-weight:600;border:1px solid #e5e7eb">
                                Reply Directly
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- ===== FOOTER ===== --}}
        <tr>
            <td style="padding:20px 36px;background:#f9fafb;border-top:1px solid #e5e7eb">
                <p style="margin:0;font-size:11px;color:#9ca3af;text-align:center;line-height:1.6">
                    This notification was sent by your portfolio contact form at<br>
                    <a href="{{ config('app.url') }}" style="color:#6366f1;text-decoration:none">{{ config('app.url') }}</a>
                </p>
            </td>
        </tr>

    </table>

</td></tr>
</table>

</body>
</html>
