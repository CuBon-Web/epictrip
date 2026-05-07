<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt tour</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <h2 style="margin-bottom: 8px;">Cảm ơn bạn đã gửi yêu cầu đặt tour</h2>
    <p>Chúng tôi đã nhận được thông tin của bạn và sẽ liên hệ sớm nhất có thể.</p>
    <p>Mã tham chiếu: <strong>#{{ $bill->id }}</strong></p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; max-width: 560px;">
        <tr><td style="border-bottom: 1px solid #eee;"><strong>Tour</strong></td><td style="border-bottom: 1px solid #eee;">{{ $tourTitle }}</td></tr>
        <tr><td style="border-bottom: 1px solid #eee;"><strong>Họ tên</strong></td><td style="border-bottom: 1px solid #eee;">{{ $bill->name }}</td></tr>
        <tr><td style="border-bottom: 1px solid #eee;"><strong>Điện thoại</strong></td><td style="border-bottom: 1px solid #eee;">{{ $bill->phone }}</td></tr>
        <tr><td style="border-bottom: 1px solid #eee;"><strong>Tổng tiền (tham khảo)</strong></td><td style="border-bottom: 1px solid #eee;">{{ $bill->total }}</td></tr>
    </table>

    <p style="margin-top: 24px; font-size: 14px; color: #666;">Trân trọng,<br>{{ config('app.name') }}</p>
</body>
</html>
