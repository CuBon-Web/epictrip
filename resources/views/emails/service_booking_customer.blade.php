<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt dịch vụ</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <p>Xin chào <strong>{{ $booking->name }}</strong>,</p>
    <p>Chúng tôi đã nhận được yêu cầu đặt dịch vụ của bạn (mã tham chiếu <strong>#{{ $booking->id }}</strong>).</p>
    <p><strong>Dịch vụ:</strong> {{ $serviceTitle }}</p>
    <p>Đội ngũ của chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>
    <p style="color: #666; font-size: 12px;">Đây là email tự động, vui lòng không trả lời trực tiếp.</p>
</body>
</html>
