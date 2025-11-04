<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CodeQuest</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #3b82f6);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated gradient background glow */
        body::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, transparent 70%);
            animation: moveGlow 10s linear infinite;
        }

        @keyframes moveGlow {
            0% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
            100% { transform: translate(0, 0); }
        }

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 100px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 12px rgba(59,130,246,0.7));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .form-control {
            border-radius: 8px;
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px #3b82f6;
            background-color: rgba(255,255,255,0.15);
        }

        .form-label {
            color: #e2e8f0;
            font-weight: 500;
        }

        .btn-login {
            background-color: #2563eb;
            color: #fff;
            border-radius: 8px;
            padding: 0.6rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
            transform: scale(1.03);
        }

        .footer-text {
            text-align: center;
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-top: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <!-- Replace with your actual logo -->
        <img src="{{ asset('images/codequest-logo.png') }}" alt="CodeQuest Logo" class="logo">

        <h3 class="fw-bold mb-4 text-info">Welcome Back!</h3>

        <!-- Laravel messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST" class="text-start">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </button>
        </form>

        <div class="footer-text mt-3">
            © {{ date('Y') }} CodeQuest. All rights reserved.
        </div>
    </div>

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a2e0e6ad5d.js" crossorigin="anonymous"></script>

</body>
</html>
