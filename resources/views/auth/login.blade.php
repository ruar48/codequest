<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | CodeQuest</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top, #0a1128 0%, #001845 40%, #00296b 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Subtle animated background glow */
    body::before {
      content: "";
      position: absolute;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
      top: -50%;
      left: -50%;
      animation: moveGlow 8s linear infinite;
    }

    @keyframes moveGlow {
      0% { transform: translate(0, 0); }
      50% { transform: translate(50px, 30px); }
      100% { transform: translate(0, 0); }
    }

    .login-card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      background: linear-gradient(145deg, rgba(0,35,102,0.85), rgba(1,22,56,0.9));
      border: 2px solid #1e3a8a;
      border-radius: 18px;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 20px rgba(59,130,246,0.4);
      backdrop-filter: blur(10px);
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo {
      width: 120px;
      margin-bottom: 1rem;
      filter: drop-shadow(0 0 12px rgba(255, 215, 0, 0.7));
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    .login-title {
      color: #facc15;
      font-weight: 700;
      font-size: 1.6rem;
      text-shadow: 0 0 8px rgba(250, 204, 21, 0.6);
    }

    .form-label {
      color: #ffffffff;
      font-weight: 500;
    }

    .form-control {
      border-radius: 8px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.3);
      color: #fff;
    }

    .form-control:focus {
      border-color: #facc15;
      box-shadow: 0 0 8px #facc15;
      background-color: rgba(255,255,255,0.15);
    }

    .btn-login {
      background: linear-gradient(90deg, #facc15, #fbbf24);
      color: #0f172a;
      font-weight: 700;
      border-radius: 10px;
      padding: 0.6rem;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      transform: scale(1.05);
      box-shadow: 0 0 18px #facc15;
    }

    .footer-text {
      color: #9ca3af;
      margin-top: 1.2rem;
      font-size: 0.9rem;
    }

    .alert {
      text-align: left;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <!-- Logo -->
    <img src="{{ asset('dist/img/codequest-logo.png') }}" alt="CodeQuest Logo" class="logo">

    <h3 class="login-title mb-4">Welcome Back, Adventurer!</h3>

    <!-- Success Message -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Error Message -->
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login.submit') }}" method="POST" class="text-start mt-3">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="you@example.com" value="{{ old('email') }}" required>
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

      <button type="submit" class="btn btn-login w-100 mt-3">
        <i class="fas fa-sign-in-alt me-2"></i> Login
      </button>
    </form>

    <div class="footer-text">
      © {{ date('Y') }} CodeQuest. All rights reserved.
    </div>
  </div>

  <script src="https://kit.fontawesome.com/a2e0e6ad5d.js" crossorigin="anonymous"></script>
</body>
</html>
