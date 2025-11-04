<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | CodeQuest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 2rem 3rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }
        .welcome-logo {
            font-size: 3rem;
            color: #fff;
        }
        .btn-custom {
            background-color: #2563eb;
            color: #fff;
            border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #1e40af;
            transform: scale(1.05);
        }
        footer {
            position: absolute;
            bottom: 1rem;
            color: #d1d5db;
            font-size: 0.9rem;
        }
        .logo-img {
    width: 120px;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}
    </style>
</head>
<body>

    <div class="welcome-card text-center">
        <div class="welcome-logo mb-3">
    <img src="{{ asset('images/logo_1.png') }}" alt="CodeQuest Logo" class="logo-img">
</div>
        <h1 class="fw-bold">Welcome to <span class="text-info">CodeQuest</span></h1>
        <p class="lead mt-2 mb-4">An interactive platform for learning and testing your coding skills.</p>

        @if (Route::has('login'))
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-custom me-2">
                        <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom me-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-user-plus"></i> Register
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
