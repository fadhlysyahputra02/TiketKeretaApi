<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Berhasil Diubah</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #43cea2, #185a9d);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: #333;
            padding: 20px;
        }
        .success-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 420px;
            width: 100%;
            text-align: center;
            padding: 40px 25px;
            animation: fadeIn 0.8s ease-in-out;
        }
        .success-icon {
            font-size: 60px;
            color: #43cea2;
            margin-bottom: 20px;
        }
        .success-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .success-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 30px;
        }
        .btn-login {
            background: #185a9d;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #0e3f74;
            color: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="success-icon">🎉</div>
        <div class="success-title">Password Berhasil Diubah!</div>
        <p class="success-text">Anda telah berhasil mengatur ulang password. Silakan login kembali menggunakan password baru Anda.</p>

        <a href="{{ route('login') }}" class="btn btn-login w-100">Kembali ke Halaman Login</a>
    </div>

    {{-- Bootstrap JS (opsional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
