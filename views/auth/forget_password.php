<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --pastel-bg: #f3f4f9;
            --primary-pastel: #5d55cb;
            --primary-dark: #8379f7;
            --dark-text: #2d3436;
            --muted-text: #b2bec3;
            --soft-border: #dfe6e9;
        }

        body {
            background-color: var(--pastel-bg);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .custom-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 50px 45px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 15px 35px rgba(162, 155, 254, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.8);
            animation: fadeInUp 0.6s ease-out;
        }

        h2 {
            font-weight: 700;
            color: var(--dark-text);
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--muted-text);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 35px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--dark-text);
            margin-left: 4px;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 16px;
            padding: 14px 20px;
            border: 2px solid var(--soft-border);
            font-weight: 600;
            background-color: #f9f9ff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-pastel);
            box-shadow: 0 0 0 4px rgba(162, 155, 254, 0.1);
            background-color: #fff;
            outline: none;
        }

        .password-wrapper {
            position: relative;
        }

        .form-control-password {
            padding-right: 55px !important;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted-text);
            font-size: 1.2rem;
            z-index: 10;
        }

        input::-ms-reveal, input::-webkit-password-reveal {
            display: none !important;
        }

        .btn-custom {
            background-color: var(--primary-pastel);
            border: none;
            border-radius: 16px;
            padding: 16px;
            color: white;
            font-weight: 700;
            width: 100%;
            margin-top: 15px;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(162, 155, 254, 0.3);
        }

        .btn-custom:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            color: white;
        }

        .alert-custom {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            font-weight: 600;
            border-radius: 14px;
            font-size: 0.85rem;
            padding: 12px;
            margin-bottom: 25px;
        }

        .footer-text {
            font-weight: 600;
            font-size: 0.85rem;
            color: #718096;
            margin-top: 25px;
        }

        .link-pastel {
            color: var(--primary-pastel);
            text-decoration: none;
            font-weight: 700;
        }

        .link-pastel:hover {
            text-decoration: underline;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="custom-card text-center">
        <h2>Reset Password</h2>
        <p class="subtitle">Enter your details to set a new password</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-custom d-flex align-items-center justify-content-center">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../../controllers/ForgotPasswordController.php" class="text-start">

            <div class="mb-3">
                <label class="form-label">Username / Email</label>
                <input type="text" name="identifier" class="form-control" placeholder="Your username or email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <div class="password-wrapper">
                    <input type="password" name="new_password" id="pass1" class="form-control form-control-password" placeholder="••••••••" required>
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('pass1', this)"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="confirm_password" id="pass2" class="form-control form-control-password" placeholder="••••••••" required>
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass('pass2', this)"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-custom">
                Update Password <i class="bi bi-arrow-right-short ms-1"></i>
            </button>

        </form>

        <p class="footer-text">
            Remembered? <a href="login.php" class="link-pastel">Back to Login</a>
        </p>
    </div>

    <script>
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = "password";
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>