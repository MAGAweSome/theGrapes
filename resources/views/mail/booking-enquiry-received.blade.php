@php
    $booking = $booking ?? [];
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking enquiry received</title>
    </head>
    <body style="margin:0; padding:0; background:#f5efe6; font-family: Arial, Helvetica, sans-serif; color:#1f130c;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5efe6; padding:32px 16px;">
            <tr>
                <td align="center">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border:1px solid #eadfce; border-radius:24px; overflow:hidden; box-shadow:0 16px 40px rgba(31, 19, 12, 0.08);">
                        <tr>
                            <td style="background:linear-gradient(135deg, #1b120d 0%, #2d1d14 100%); padding:32px 32px 28px; text-align:center;">
                                <div style="display:inline-block; border:1px solid rgba(240, 165, 111, 0.35); border-radius:999px; padding:6px 14px; color:#f0a56f; font-size:12px; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; margin-bottom:16px;">
                                    The Grapes
                                </div>
                                <h1 style="margin:0; color:#ffffff; font-size:28px; line-height:1.2; font-weight:700;">New booking enquiry</h1>
                                <p style="margin:12px 0 0; color:#e6d5c4; font-size:15px; line-height:1.6;">A visitor submitted the booking form on the website.</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:32px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:0 12px; margin-bottom:24px;">
                                    <tr>
                                        <td style="width:50%; padding-right:6px;">
                                            <div style="background:#faf6f1; border:1px solid #eadfce; border-radius:18px; padding:16px 18px;">
                                                <div style="font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#9a7b62; margin-bottom:6px;">Name</div>
                                                <div style="font-size:16px; line-height:1.5; font-weight:700; color:#1f130c;">{{ $booking['name'] ?? '' }}</div>
                                            </div>
                                        </td>
                                        <td style="width:50%; padding-left:6px;">
                                            <div style="background:#faf6f1; border:1px solid #eadfce; border-radius:18px; padding:16px 18px;">
                                                <div style="font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#9a7b62; margin-bottom:6px;">Email</div>
                                                <div style="font-size:16px; line-height:1.5; font-weight:700; color:#1f130c; word-break:break-word;">{{ $booking['email'] ?? '' }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; padding-right:6px;">
                                            <div style="background:#faf6f1; border:1px solid #eadfce; border-radius:18px; padding:16px 18px;">
                                                <div style="font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#9a7b62; margin-bottom:6px;">Event date</div>
                                                <div style="font-size:16px; line-height:1.5; font-weight:700; color:#1f130c;">{{ $booking['event_date'] ?? '' }}</div>
                                            </div>
                                        </td>
                                        <td style="width:50%; padding-left:6px;">
                                            <div style="background:#faf6f1; border:1px solid #eadfce; border-radius:18px; padding:16px 18px;">
                                                <div style="font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#9a7b62; margin-bottom:6px;">Venue</div>
                                                <div style="font-size:16px; line-height:1.5; font-weight:700; color:#1f130c;">{{ $booking['venue'] ?? '' }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <div style="background:#fff8f1; border:1px solid #f0d9be; border-radius:20px; padding:22px 20px;">
                                    <div style="font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#9a7b62; margin-bottom:10px;">Details</div>
                                    <div style="font-size:15px; line-height:1.8; color:#3e2b1f; white-space:pre-wrap;">{{ $booking['details'] ?? '' }}</div>
                                </div>

                                <p style="margin:24px 0 0; font-size:13px; line-height:1.6; color:#7d6757;">
                                    This enquiry came from the public booking form on The Grapes website.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>