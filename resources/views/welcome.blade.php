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
    background: #ffffff; /* page background white */
    color: #333; /* default body text (outside card) */
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    overflow: hidden;
    position: relative;
    text-align: center;
  }

  .welcome-card {
    position: relative;
    z-index: 1;
    background: #ffffff; /* container background white */
    border: 2px solid #7b2d2d; /* maroon border */
    border-radius: 20px;
    padding: 2.5rem 3rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15), 0 0 25px rgba(123,45,45,0.2); /* subtle shadow */
    max-width: 480px;
  }

  .welcome-card h1,
  .welcome-card p,
  .welcome-card .lead {
    color: #7b2d2d; /* maroon text inside container */
  }

  /* Logo */
  .logo-img {
    width: 140px;
    filter: drop-shadow(0 0 12px rgba(123,45,45,0.5)); /* subtle maroon glow */
    animation: float 3s ease-in-out infinite;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }

  /* Buttons */
  .btn-custom {
    background: #7b2d2d; /* maroon button */
    color: #ffffff; /* white text */
    border: none;
    border-radius: 2rem;
    padding: 0.6rem 1.5rem;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 0 12px rgba(123,45,45,0.4);
  }
  .btn-custom:hover {
    transform: scale(1.07);
    box-shadow: 0 0 20px rgba(123,45,45,0.6);
  }

  .btn-outline {
    border: 2px solid #7b2d2d; /* maroon outline */
    color: #7b2d2d;
    border-radius: 2rem;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-outline:hover {
    background: #7b2d2d;
    color: #ffffff;
    box-shadow: 0 0 15px rgba(123,45,45,0.4);
    transform: scale(1.07);
  }

  /* Input placeholders */
  input::placeholder,
  textarea::placeholder {
    color: #7b2d2d; /* maroon placeholder */
    opacity: 1;
  }

  footer {
    position: absolute;
    bottom: 1rem;
    color: #7b2d2d; /* maroon footer */
    font-size: 0.9rem;
    z-index: 1;
  }
</style>
</head>
<body>

  <div class="welcome-card text-center">
    <div class="welcome-logo mb-4">
      <img src="{{ asset('dist/img/codequest-logo.png') }}" alt="CodeQuest Logo" class="logo-img">
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
