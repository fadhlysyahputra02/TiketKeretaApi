<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Ubah Password</h2>
    <form action="/api/reset-password/{{ $token }}" method="POST">
        @csrf
        <label>Password Baru:</label><br>
        <input type="password" name="new_password" required><br>
        <label>Konfirmasi Password:</label><br>
        <input type="password" name="new_password_confirmation" required><br><br>

        <button type="submit">Ubah Password</button>
    </form>
</body>
</html>
