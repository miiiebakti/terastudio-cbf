
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

<body class="min-h-screen flex flex-col bg-[#F5FEFF] text-[#0E2F76]">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold text-[#0E2F76]">
                TeraStudio<span class="text-[#AAC0E1]">.</span>
            </a>

            <div class="flex gap-6 items-center text-sm font-medium">

                <a href="{{ route('home') }}"
                   class="hover:text-[#AAC0E1] transition">
                    Beranda
                </a>

                <a href="{{ route('packages') }}"
                   class="hover:text-[#AAC0E1] transition">
                    Katalog Paket
                </a>

                @auth
                <a href="{{ route('history.index') }}"
                    class="hover:text-[#AAC0E1] transition">
                        History Booking
                    </a>

                    <span class="hidden sm:inline text-[#0E2F76]">
                        Halo, {{ Auth::user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-[#0E2F76] text-white px-5 py-2 rounded-full hover:bg-[#AAC0E1] transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="hover:text-[#AAC0E1] transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-[#0E2F76] text-white px-5 py-2 rounded-full hover:bg-[#AAC0E1] transition">
                        Daftar
                    </a>
                @endauth

            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <main class="flex-1 w-full">
    <div class="max-w-7xl mx-auto px-6 pt-4">

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
                <p class="font-bold mb-2">Booking belum berhasil:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#AAC0E1]/40 mt-16">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm text-[#0E2F76]/70">
            © {{ date('Y') }} TeraStudio. Little Moment, Big Memories.
        </div>
    </footer>

</body>
</html>
