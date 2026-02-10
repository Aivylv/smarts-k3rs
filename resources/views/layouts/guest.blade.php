<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Login' }} - {{ config('app.name', 'SMART K3') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-pattern {
            background-image: 
                radial-gradient(ellipse at 20% 30%, rgba(147, 197, 253, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(196, 181, 253, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(165, 243, 252, 0.2) 0%, transparent 70%);
        }
        .floating-shapes div {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(147, 197, 253, 0.3), rgba(196, 181, 253, 0.3));
            animation: float 8s ease-in-out infinite;
        }
        .floating-shapes div:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        .floating-shapes div:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        .floating-shapes div:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 bg-pattern">
    <!-- Floating Shapes Background -->
    <div class="floating-shapes fixed inset-0 overflow-hidden pointer-events-none">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Content -->
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        {{ $slot }}
    </div>
</body>
</html>
