
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TeraStudio</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-600">
                TeraStudio.
            </a>

            <div class="flex gap-6 items-center">
                <a href="{{ route('home') }}" class="hover:text-pink-600">
                    Beranda
                </a>

                <a href="{{ route('packages') }}" class="hover:text-pink-600">
                    Katalog Paket
                </a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-gray-500 text-sm">
            © {{ date('Y') }} TeraStudio. Little Moment Big Memories.
        </div>
    </footer>

</body>
</html>
