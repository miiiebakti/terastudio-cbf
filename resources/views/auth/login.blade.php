
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TeraStudio</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F5FEFF] flex items-center justify-center p-5">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="bg-[#0E2F76] text-white text-center px-8 py-10">
            <h1 class="text-3xl font-bold">TeraStudio</h1>
            <p class="text-blue-100 mt-2">Little Moment, Big Memories</p>
            <p class="text-sm mt-5">
                Selamat datang kembali!
            </p>
        </div>

        <div class="p-8">

            <h2 class="text-2xl font-bold text-[#0E2F76] mb-2">
                Login
            </h2>

            <p class="text-gray-500 text-sm mb-6">
                Masuk ke akunmu untuk melihat rekomendasi paket.
            </p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        class="w-full mt-2 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full mt-2 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="accent-[#0E2F76]"
                    >

                    <label class="text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#0E2F76] hover:bg-[#AAC0E1] hover:text-[#0E2F76] text-white font-semibold py-3 rounded-xl transition duration-300"
                >
                    Masuk
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum punya akun?

                <a href="{{ route('register') }}"
                   class="text-[#0E2F76] font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

            <div class="text-center mt-5">
                <a href="{{ route('home') }}"
                   class="text-sm text-gray-400 hover:text-[#0E2F76]">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

</body>
</html>
