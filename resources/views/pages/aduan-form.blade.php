<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basmi - Bersih Aksi Suap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Tambahkan Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            background-image: url('../assets/img/bg_home.png');
            background-size: cover;
            /* biar menyesuaikan layar */
            background-position: center;
            /* fokus di tengah */
            background-repeat: no-repeat;
            /* jangan diulang */
            background-attachment: fixed;
            /* biar efek parallax */
        }
    </style>
</head>

<body class="font-sans">
    <header class="bg-teal-800 text-white p-4 flex justify-between items-center shadow-md relative">
        <h1 class="text-xl font-bold">BASMI</h1>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{route('home')}}" class="font-bold py-1 hover:text-yellow-300 transition">Beranda </a>
            <a href="{{route('laporan')}}" class="font-bold py-1 hover:text-yellow-300 transition">Jelajahi Aduan </a>
            <a href="{{route('about')}}" class="font-bold py-1 hover:text-yellow-300 transition">Tentang</a>

        </nav>

        <!-- Burger Button (Mobile) -->
        <button id="burger" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Mobile Menu (Hidden by default) -->
    <nav id="mobileMenu" class="hidden md:hidden flex-col bg-teal-700 text-white px-4 py-3 space-y-3">
        <a href="{{route('about')}}" class=" block hover:bg-teal-600 rounded px-3 py-2 transition">Tentang</a>
         <form action="{{ route('logout') }}" method="POST" class="inline">
             @csrf
            <button type="submit" class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
            Logout
          </button>
          </form>
    </nav>

    <!-- Aduan Section -->
    <!-- Container Form -->
    <main class="max-w-3xl mx-auto my-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Informasi Aduan</h2>
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Upload Foto / Kamera -->
        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Foto Kejadian</label>
            <div class="border-2 border-dashed border-teal-300 rounded-lg p-6 text-center">
                <svg class="mx-auto h-10 w-10 text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6H19a3 3 0 010 6h-1M7 16l4-4m0 0l4-4m-4 4v12" />
                </svg>
                <p class="text-teal-600 font-medium mt-2">Unggah Lampiran</p>
                <p class="text-gray-500 text-sm">JPEG, JPG, PNG, PDF, MP4 (Maksimal 3 file, 5MB)</p>
                <input type="file" name="lampiran" accept="image/*,video/*,.pdf" capture="environment" multiple class="mt-3 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
        file:rounded-full file:border-0 file:text-sm file:font-semibold
        file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
            </div>
        </div>

        <!-- Isi Aduan -->
        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Deskripsi Kejadian</label>

            <!-- Quick Templates -->
            <div class="mb-3 p-3 bg-teal-50 rounded-lg border border-teal-200">
                <p class="text-sm font-medium text-teal-800 mb-2">🚀 Template Cepat (klik untuk gunakan):</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="useTemplate('Ada pungli Rp [jumlah] di [lokasi]')"
                            class="text-xs bg-white border border-teal-300 text-teal-700 px-3 py-1 rounded-full hover:bg-teal-100 transition">
                        💰 Pungli uang
                    </button>
                    <button type="button" onclick="useTemplate('Dipaksa bayar Rp [jumlah] di [lokasi] oleh [siapa]')"
                            class="text-xs bg-white border border-teal-300 text-teal-700 px-3 py-1 rounded-full hover:bg-teal-100 transition">
                        ⚠️ Paksaan bayar
                    </button>
                    <button type="button" onclick="useTemplate('Diminta uang Rp [jumlah] untuk [keperluan] di [lokasi]')"
                            class="text-xs bg-white border border-teal-300 text-teal-700 px-3 py-1 rounded-full hover:bg-teal-100 transition">
                        📋 Permintaan uang
                    </button>
                    <button type="button" onclick="useTemplate('Tidak boleh lewat tanpa bayar Rp [jumlah] di [lokasi]')"
                            class="text-xs bg-white border border-teal-300 text-teal-700 px-3 py-1 rounded-full hover:bg-teal-100 transition">
                        🚫 Halangan lewat
                    </button>
                </div>
            </div>

            <textarea
                id="deskripsi"
                name="deskripsi"
                class="border border-gray-300 rounded-lg p-2 h-40 w-full resize-none"
                placeholder="Contoh: Ada pungli Rp 50rb di terminal"
                minlength="15"
                maxlength="5000"
                oninput="updateCharCount()"
                required>{{ old('deskripsi', session('laporan_data.deskripsi')) }}</textarea>

            <!-- Character Counter & Helper -->
            <div class="flex justify-between items-center mt-2 text-sm">
                <p class="text-gray-600">
                    💡 <span class="font-medium">Tips:</span> Minimal 15 karakter. Jelaskan lokasi, jumlah, dan siapa yang melakukan.
                </p>
                <p id="charCount" class="text-gray-500 font-medium">
                    <span id="currentCount">0</span>/5000
                </p>
            </div>

            @error('deskripsi')
           <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
           @enderror
        </div>

        <script>
            function useTemplate(template) {
                const textarea = document.getElementById('deskripsi');
                textarea.value = template;
                textarea.focus();
                updateCharCount();

                // Highlight placeholder dalam kurung siku
                const start = textarea.value.indexOf('[');
                if (start !== -1) {
                    const end = textarea.value.indexOf(']', start) + 1;
                    textarea.setSelectionRange(start, end);
                }
            }

            function updateCharCount() {
                const textarea = document.getElementById('deskripsi');
                const currentCount = document.getElementById('currentCount');
                const charCount = document.getElementById('charCount');

                const length = textarea.value.length;
                currentCount.textContent = length;

                // Color coding
                if (length < 15) {
                    charCount.className = 'text-red-500 font-medium';
                } else if (length < 30) {
                    charCount.className = 'text-yellow-500 font-medium';
                } else {
                    charCount.className = 'text-green-600 font-medium';
                }
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateCharCount();
            });
        </script>



        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Lokasi Aduan</label>
            <div class="relative mt-2">
                <select id="kecamatan" name="kecamatan_id"  class="w-full">
                    <option value="">-- Cari Kecamatan --</option>
                    @foreach($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan->id }}"
                        {{ old('kecamatan_id', session('laporan_data.kecamatan_id')) == $kecamatan->id ? 'selected' : '' }}>
                        {{ $kecamatan->nama }}
                    </option>
                   @endforeach
                </select>
            </div>
            {{-- <div class="relative my-5">
                <!-- Pilih Desa -->
                <select id="desa" name="desa_id" class="w-full border rounded-lg ">
                    <option value="">-- Pilih Kecamatan dulu --</option>
                     @foreach($desas as $desa)
                    <option value="{{ $desa->id }}"
                    {{ old('desa_id', $laporanData['desa_id'] ?? '') == $desa->id ? 'selected' : '' }}>
                    {{ $desa->nama }}
                    </option>
                 @endforeach
                </select>
            </div> --}}

        </div>

        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Detail Lokasi</label>
            <textarea name="lokasi" class="border w-full border-gray-300 rounded-lg p-2 h-20 resize-none"
                placeholder="Tulis sesuatu di sini...">{{ old('lokasi', session('laporan_data.lokasi')) }}</textarea>
        </div>



        <!-- Tombol -->
       <div class="flex justify-between mb-6">
            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg shadow hover:bg-teal-700 transition">Selanjutnya</button>
        </div>
    </form>
    </main>


    <!-- Section Form -->



    <!-- Footer -->
    <footer class="text-white mt-10 p-6" style="background-color: #4B473B; ">
        <div class="max-w-6xl ml-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="font-semibold mb-2">Kanal Aduan</h4>
                <ul class="text-sm space-y-1">
                    <li>Email: Basmi@gmail.vom</li>
                    <li>Instagram: @Basmi</li>
                    <li>Twitter: @Basmi_</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Kontak Kami</h4>
                <p class="text-sm">Jl. Pendidikan No. 30, Permata Biru, Kab Bandung</p>
                <p class="text-sm">Google Maps Link</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Link Lain</h4>
                <ul class="text-sm space-y-1">
                    <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:underline">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-xs text-gray-300 mt-6">
            Hak Cipta © 2025 tim new home KIBB
        </div>
    </footer>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/script/burger-menu.js')}}"></script>



</body>

</html>



