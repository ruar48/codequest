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
    background: #ffffff; /* page background white */
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
  }

  .login-card {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 420px;
    background: #ffffff; /* card container background white */
    border: 2px solid #7b2d2d; /* maroon border */
    border-radius: 18px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(123, 45, 45, 0.2), 0 0 20px rgba(123, 45, 45, 0.1); /* subtle shadow */
  }

  /* Logo */
  .logo {
    width: 120px;
    margin-bottom: 1rem;
    filter: drop-shadow(0 0 12px rgba(123,45,45,0.5)); /* maroon glow */
    animation: float 3s ease-in-out infinite;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }

  .login-title {
    color: #7b2d2d; /* maroon title text */
    font-weight: 700;
    font-size: 1.6rem;
    margin-bottom: 1.5rem;
  }

  .form-label {
    color: #7b2d2d; /* maroon labels */
    font-weight: 500;
  }

  .form-control {
    border-radius: 8px;
    background: rgba(123, 45, 45, 0.05); /* light transparent maroon background */
    border: 1px solid #7b2d2d; /* maroon border */
    color: #7b2d2d; /* text inside inputs maroon */
  }

  .form-control::placeholder {
    color: #7b2d2d; /* maroon placeholder */
    opacity: 1;
  }

  .form-control:focus {
    border-color: #7b2d2d;
    box-shadow: 0 0 8px rgba(123,45,45,0.3);
    background-color: rgba(123,45,45,0.1);
    color: #7b2d2d;
  }

  .btn-login {
    background: #7b2d2d; /* maroon button */
    color: #ffffff; /* white text */
    font-weight: 700;
    border-radius: 10px;
    padding: 0.6rem;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-login:hover {
    transform: scale(1.05);
    box-shadow: 0 0 18px rgba(123,45,45,0.5);
  }

  .footer-text {
    color: #7b2d2d; /* maroon footer */
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

    <!-- ✅ Updated Login Form (Credentials Section) -->
    <form action="{{ route('login.submit') }}" method="POST" class="text-start mt-3">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input 
          type="email" 
          name="email" 
          id="email" 
          value="john.doe@example.com"
          class="form-control @error('email') is-invalid @enderror"
          required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input 
          type="password" 
          name="password" 
          id="password" 
          value="secretpassword"
          class="form-control @error('password') is-invalid @enderror"
          required>
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
