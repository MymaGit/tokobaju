<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') &middot; Gavin Fashion Store</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <div class="auth">
        {{-- Panel kiri: foto saja. Teks menyusul setelah desain Figma final. --}}
        <aside class="auth__brand" role="img"
               aria-label="Interior Gavin Fashion Store"></aside>

        <main class="auth__panel">
            <div class="auth__card">
                @yield('content')
            </div>
            <p class="auth__foot">&copy; {{ date('Y') }} Gavin Fashion Store. Hak cipta dilindungi.</p>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
