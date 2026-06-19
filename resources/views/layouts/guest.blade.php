<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Akun') - DISTRICT TRIF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Hanken+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
<div class="min-h-screen relative flex items-center justify-center px-margin-mobile py-16 overflow-hidden">
    <div class="absolute inset-0 bg-surface-container-lowest"></div>

    <div class="relative z-10 w-full max-w-lg">
        <div class="glass-panel rounded-xl p-8 md:p-12 animate-fadeUp">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="font-display text-headline-lg text-on-surface no-underline">DISTRICT TRIF</a>
                <p class="vc-kicker mt-2 mb-0">Toko Online</p>
            </div>
            @include('partials.alerts')
            @yield('content')
        </div>
        <p class="text-center text-on-surface-variant mt-6 small">
            <a href="{{ route('home') }}" class="text-primary no-underline">&larr; Kembali ke Home</a>
        </p>
    </div>
</div>
</body>
</html>
