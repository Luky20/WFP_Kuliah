<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    
    {{-- Bootstrap CSS (opsional, bisa pakai Tailwind juga) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Tambahkan CSS custom kalau ada --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar sederhana --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">My App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    {{-- Konten utama --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-light text-center py-3 mt-4">
        <small>&copy; {{ date('Y') }} My App. All rights reserved.</small>
    </footer>

    {{-- Bootstrap JS (opsional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tambahkan script custom kalau ada --}}
    @stack('scripts')
</body>
</html>
