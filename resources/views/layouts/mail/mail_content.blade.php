<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác minh tài khoản</title>
</head>
<body>
    {{-- <h1>Xin chào {{ $user->user_name }},</h1> --}}
    <p>Vui lòng nhấp vào nút bên dưới để xác minh tài khoản của bạn:</p>
    <a href="{{ $verificationUrl }}" style="display: inline-block; background-color: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Xác minh tài khoản</a>
    <p>Cảm ơn bạn!</p>
</body>
</html>