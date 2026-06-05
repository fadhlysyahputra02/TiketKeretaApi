```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            overflow: hidden;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* LEFT */
        .login-section {
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(30px);
            border-radius: 28px;
            padding: 45px;
            box-shadow:
                0 10px 40px rgba(0,0,0,0.25),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .logo {
            width: 180px;
            display: block;
            margin: auto;
            margin-bottom: 25px;
        }

        h2 {
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: 600;
        }

        .subtitle {
            text-align: center;
            color: rgba(255,255,255,0.7);
            margin-top: 8px;
            margin-bottom: 35px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 15px 18px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.08);
            color: white;
            outline: none;
            transition: all .3s ease;
            margin-bottom: 20px;
            font-size: 14px;
        }

        input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.2);
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 55px;
        }

        .toggle-password {
            position: absolute;
            top: 44%;
            right: 18px;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255,255,255,0.7);
            transition: .3s;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: white;
        }

        button {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 15px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s ease;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37,99,235,0.35);
        }

        .error-message {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fecaca;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
        }

        /* RIGHT */
        .image-section {
            width: 55%;
            position: relative;
            background:
                linear-gradient(rgba(15,23,42,.45), rgba(15,23,42,.65)),
                url('https://images.unsplash.com/photo-1514565131-fce0801e5785?auto=format&fit=crop&w=1400&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tagline {
            color: white;
            font-size: 42px;
            font-weight: 700;
            text-align: center;
            width: 70%;
            line-height: 1.4;
            text-shadow: 0 5px 20px rgba(0,0,0,.35);
        }

        @media(max-width: 900px) {
            .image-section {
                display: none;
            }

            .login-section {
                width: 100%;
            }

            .login-box {
                padding: 35px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- LEFT -->
    <div class="login-section">
        <div class="login-box">

            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/Logo_PT_Kereta_Api_Indonesia_%28Persero%29.svg/2560px-Logo_PT_Kereta_Api_Indonesia_%28Persero%29.svg.png"
                 alt="Logo"
                 class="logo">

            <h2>Admin Login</h2>
            <p class="subtitle">
                Sign in to access dashboard system
            </p>

            {{-- Error --}}
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

                <label>Password</label>

                <div class="password-container">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                    <span
                        class="toggle-password"
                        onclick="togglePassword()">
                        👁️
                    </span>
                </div>

                <button type="submit">
                    Sign In
                </button>
            </form>

            <p class="footer">
                © 2026 Kereta Api Admin Portal
            </p>

        </div>
    </div>

    <!-- RIGHT -->
    <div class="image-section">
        <h1 class="tagline">
            Welcome to Railway Admin Portal
        </h1>
    </div>

</div>

<script>
    function togglePassword() {
        const passwordInput =
            document.getElementById("password");

        const toggleIcon =
            document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.innerHTML = "🙈";
        } else {
            passwordInput.type = "password";
            toggleIcon.innerHTML = "👁️";
        }
    }
</script>

</body>
</html>
```
