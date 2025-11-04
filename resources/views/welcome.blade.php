<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | CodeQuest</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top, #0a1128 0%, #001845 40%, #00296b 100%);
      color: #fff;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      overflow: hidden;
      position: relative;
      text-align: center;
    }

    /* Animated background glow */
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
      50% { transform: translate(60px, 40px); }
      100% { transform: translate(0, 0); }
    }

    .welcome-card {
      position: relative;
      z-index: 1;
      background: linear-gradient(145deg, rgba(0,35,102,0.85), rgba(1,22,56,0.9));
      border-radius: 20px;
      padding: 2.5rem 3rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 25px rgba(59,130,246,0.4);
      backdrop-filter: blur(10px);
      max-width: 480px;
      animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo-img {
      width: 140px;
      filter: drop-shadow(0 0 12px rgba(250,204,21,0.8));
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    h1 span {
      color: #facc15;
      text-shadow: 0 0 10px rgba(250,204,21,0.6);
    }

    .lead {
      color: #dbeafe;
      font-size: 1rem;
    }

    .btn-custom {
      background: linear-gradient(90deg, #facc15, #fbbf24);
      color: #0f172a;
      border: none;
      border-radius: 2rem;
      padding: 0.6rem 1.5rem;
      font-weight: 700;
      transition: all 0.3s ease;
      box-shadow: 0 0 12px rgba(250,204,21,0.5);
    }

    .btn-custom:hover {
      transform: scale(1.07);
      box-shadow: 0 0 20px rgba(250,204,21,0.9);
    }

    .btn-outline {
      border: 2px solid #facc15;
      color: #facc15;
      border-radius: 2rem;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-outline:hover {
      background: #facc15;
      color: #0f172a;
      box-shadow: 0 0 15px #facc15;
      transform: scale(1.07);
    }

    footer {
      position: absolute;
      bottom: 1rem;
      color: #9ca3af;
      font-size: 0.9rem;
      z-index: 1;
    }
  </style>
</head>
<body>

  <div class="welcome-card text-center">
    <div class="welcome-logo mb-4">
      <img src="{{ asset('dist/img/codequest_logo.png') }}" alt="CodeQuest Logo" class="logo-img">
    </div>

    <h1 class="fw-bold">Welcome to <span>CodeQuest</span></h1>
    <p class="lead mt-2 mb-4">An interactive platform for learning and testing your coding skills.</p>

    @if (Route::has('login'))
      <div class="mt-3 d-flex justify-content-center flex-wrap gap-2">
        @auth
          <a href="{{ url('/dashboard') }}" class="btn btn-custom">
            <i class="fas fa-tachometer-alt"></i> Go to Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="btn btn-custom">
            <i class="fas fa-sign-in-alt"></i> Login
          </a>

          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline">
              <i class="fas fa-user-plus"></i> Start New Quest
            </a>
          @endif
        @endauth
      </div>
    @endif
  </div>

  <footer>
    &copy; {{ date('Y') }} CodeQuest. All rights reserved.
  </footer>

</body>
</html>
