<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif">
    <div style="max-width:560px;margin:40px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08)">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#6366f1,#4f46e5);padding:32px 36px">
            <h1 style="margin:0;color:#fff;font-size:20px;font-weight:700">📩 New Contact Message</h1>
            <p style="margin:6px 0 0;color:rgba(255,255,255,.75);font-size:13px">
                Received {{ now()->format('D, d M Y \a\t H:i') }}
            </p>
        </div>

        {{-- Body --}}
        <div style="padding:32px 36px">
            <table style="width:100%;border-collapse:collapse">
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #f1f1f1;width:30%">
                        <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em">Name</span>
                    </td>
                    <td style="padding:10px 0;border-bottom:1px solid #f1f1f1">
                        <span style="font-size:14px;color:#111827;font-weight:500">{{ $contactMessage->name }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #f1f1f1">
                        <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em">Email</span>
                    </td>
                    <td style="padding:10px 0;border-bottom:1px solid #f1f1f1">
                        <a href="mailto:{{ $contactMessage->email }}" style="font-size:14px;color:#6366f1;text-decoration:none">{{ $contactMessage->email }}</a>
                    </td>
                </tr>
            </table>

            <div style="margin-top:24px">
                <p style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Message</p>
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:16px 20px">
                    <p style="margin:0;font-size:14px;color:#374151;line-height:1.7;white-space:pre-wrap">{{ $contactMessage->message }}</p>
                </div>
            </div>

            <div style="margin-top:28px">
                <a href="{{ url('/admin/messages') }}"
                   style="display:inline-block;background:#6366f1;color:#fff;text-decoration:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:600">
                    View in Admin Panel →
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:20px 36px;background:#f9fafb;border-top:1px solid #e5e7eb">
            <p style="margin:0;font-size:12px;color:#9ca3af;text-align:center">
                Kushal.dev Portfolio · kushalghimire57.com.np
            </p>
        </div>

    </div>
</body>
</html>
