<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ubah Password</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}</h2>
    <p>Anda meminta untuk mengubah password akun Anda.</p>
    <a href="{{ $url }}" style="background:#28A745;color:#fff;padding:10px 20px;text-decoration:none;border-radius:8px;">
        Ganti Password Sekarang
    </a>
</body>
</html>
