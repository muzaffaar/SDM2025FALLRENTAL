<!doctype html>
<html>
<body style="font-family:Arial,Helvetica,sans-serif;background:#f7f7f7;padding:24px;">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:620px;margin:0 auto;background:#ffffff;border:1px solid #e5e5e5;">
    <tr>
        <td style="padding:20px 24px;">
            <h2 style="margin:0 0 8px;">Hello {{ $recipientName }},</h2>
            <p style="margin:0 0 12px;">
                Your request for <strong>{{ $rentalTitle }}</strong> is now
                <strong style="text-transform:uppercase">{{ $newStatus }}</strong>.
            </p>

            @if($messageForUser)
                <p style="margin:0 0 12px;">Message: {{ $messageForUser }}</p>
            @endif

            <p style="margin:20px 0 0;color:#666;">— SDM Rental Portal</p>
        </td>
    </tr>
</table>
</body>
</html>
