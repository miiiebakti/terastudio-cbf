
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - TeraStudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[#F5FEFF] flex items-center justify-center p-5">

    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="bg-[#0E2F76] text-white text-center px-8 py-8">
            <h1 class="text-3xl font-bold">TeraStudio</h1>
            <p class="text-blue-100 mt-2">Little Moment, Big Memories</p>
            <p class="text-sm mt-5">Buat akun dan mulai booking momen favoritmu!</p>
        </div>

        <div class="p-8">
            <h2 class="text-2xl font-bold text-[#0E2F76] mb-2">
                Daftar Akun
            </h2>
            <p class="text-gray-500 text-sm mb-6">
                Lengkapi data berikut untuk membuat akun pelanggan.
            </p>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-5 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}"
                        placeholder="Contoh: 81234567890"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Usia</label>
                        <input type="number" name="usia" value="{{ old('usia') }}"
                            placeholder="Usia"
                            class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                            required>
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Kota Asal</label>
                    <input type="text" name="kota_asal" value="{{ old('kota_asal') }}"
                        placeholder="Masukkan kota asal"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                        placeholder="Contoh: Mahasiswa"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        placeholder="Ulangi password"
                        class="w-full mt-1 p-3 border border-[#AAC0E1] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0E2F76]"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-[#0E2F76] hover:bg-[#AAC0E1] hover:text-[#0E2F76] text-white font-semibold py-3 rounded-xl transition duration-300">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#0E2F76] font-semibold hover:underline">
                    Login di sini
                </a>
            </p>
        </div>
    </div>

</body>
</html>
