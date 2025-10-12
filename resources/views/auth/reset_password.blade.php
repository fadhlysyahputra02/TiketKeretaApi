<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Password</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4b6cb7, #182848);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 16px;
        }
        .card {
            width: 100%;
            max-width: 480px;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(90deg,#4b6cb7,#182848);
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .btn-primary {
            background: #4b6cb7;
            border: none;
        }
        .input-group .form-control {
            border-right: 0;
        }
        .input-group .btn {
            border-left: 0;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Atur Ulang Password</h4>
        <small class="text-white-50">Masukkan password baru Anda</small>
    </div>

    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="resetForm" action="{{ url('/reset-password/'.$token) }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6" aria-describedby="toggleNewPass">
                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPass" title="Lihat / Sembunyikan password">
                        <i class="bi bi-eye-slash" id="iconNewPass"></i>
                    </button>
                </div>
                <div class="form-text">Minimal 6 karakter.</div>
            </div>

            <div class="mb-4">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="6" aria-describedby="toggleConfirmPass">
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPass" title="Lihat / Sembunyikan konfirmasi password">
                        <i class="bi bi-eye-slash" id="iconConfirmPass"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Password Baru</button>
        </form>
    </div>
</div>

{{-- Bootstrap JS (optional) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle password visibility for New Password
    const toggleNew = document.getElementById('toggleNewPass');
    const newPass = document.getElementById('new_password');
    const iconNew = document.getElementById('iconNewPass');

    toggleNew.addEventListener('click', () => {
        const isHidden = newPass.type === 'password';
        newPass.type = isHidden ? 'text' : 'password';
        iconNew.className = isHidden ? 'bi bi-eye' : 'bi bi-eye-slash';
    });

    // Toggle password visibility for Confirm Password
    const toggleConfirm = document.getElementById('toggleConfirmPass');
    const confirmPass = document.getElementById('new_password_confirmation');
    const iconConfirm = document.getElementById('iconConfirmPass');

    toggleConfirm.addEventListener('click', () => {
        const isHidden = confirmPass.type === 'password';
        confirmPass.type = isHidden ? 'text' : 'password';
        iconConfirm.className = isHidden ? 'bi bi-eye' : 'bi bi-eye-slash';
    });

    // Client-side check: konfirmasi password harus cocok
    const form = document.getElementById('resetForm');
    form.addEventListener('submit', function(e) {
        const pass = newPass.value;
        const confirm = confirmPass.value;
        if (pass !== confirm) {
            e.preventDefault();
            // bootstrap style alert (simple)
            alert('Konfirmasi password tidak sama dengan password baru.');
            confirmPass.focus();
        }
    });
</script>

</body>
</html>
