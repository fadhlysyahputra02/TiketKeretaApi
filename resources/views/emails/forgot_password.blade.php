<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lupa Password</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}</h2>
    <p>Kami menerima permintaan untuk mengatur ulang password Anda.</p>
    <a href="{{ $url }}" style="background:#007BFF;color:#fff;padding:10px 20px;text-decoration:none;border-radius:8px;">
        Reset Password Sekarang
    </a>
</body>
</html>
