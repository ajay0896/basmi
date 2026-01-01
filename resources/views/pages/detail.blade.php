<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basmi - Bersih Aksi Suap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('../assets/img/bg_home.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="font-sans">

    <!-- Header -->
    <header class="bg-teal-800 text-white p-4 flex justify-between items-center shadow-md relative">
        <h1 class="text-xl font-bold">Jelajahi Aduan</h1>

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

    <!-- Mobile Menu -->
    <nav id="mobileMenu" class="hidden md:hidden flex-col bg-teal-700 text-white px-4 py-3 space-y-3">
        <a href="{{route('about')}}" class=" block hover:bg-teal-600 rounded px-3 py-2 transition">Tentang</a>
         <form action="{{ route('logout') }}" method="POST" class="inline">
             @csrf
            <button type="submit" class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
            Logout
          </button>
          </form>
    </nav>

    <!-- Detail Aduan -->
    <main class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-lg shadow">
        <!-- Title -->

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Detail Aduan</h2>
        <p class="text-gray-500">Lihat detail lengkap aduan <span
                class="font-semibold text-teal-700"></span>
        </p>

        <!-- Card Aduan -->
        <div class="mt-6 border rounded-lg shadow-sm">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-700">Rincian Aduan <span class="text-teal-700">{{$laporan->kode_laporan}}</span>
                </h3>
                <div class="space-x-2">
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">{{$laporan->status}}</span>
                </div>
            </div>

            <!-- Lampiran -->
            <div class="p-4 border-b">
                <label class="block font-semibold text-gray-700 mb-2">📎 Lampiran</label>
                <div class="flex gap-4 flex-wrap">
                     @if($laporan->foto)
                   <img src="{{ asset('storage/'.$laporan->foto) }}" class="w-40 mt-2 rounded" alt="Foto laporan">
                       @endif
                </div>
            </div>

            <!-- Lokasi & Tanggal -->
            <div class="flex justify-between items-center text-gray-500 text-sm px-4 py-2">
                <span class="flex items-center gap-1">📍 {{$laporan->lokasi_kejadian}}, {{ $laporan->kecamatan->nama }}</span>
                <span>📅 {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->isoFormat('D MMMM YYYY') }}</span>
                <span>🔖 {{ $laporan->tags_count }} ditandai</span>
            </div>

            <!-- Isi Aduan -->
            <div class="p-6 leading-relaxed text-gray-700 space-y-4">
                <p>{{$laporan->deskripsi_kejadian}}</p>
                {{-- <p>
                    Telah terjadi praktik pungutan liar oleh oknum tidak bertanggung jawab di kawasan Masjid Al Jabbar,
                    khususnya di area parkir dan fasilitas sekitar. Warga maupun jamaah diminta uang tambahan yang tidak
                    sesuai dengan
                    ketentuan resmi. Hal ini meresahkan masyarakat dan mengurangi kenyamanan pengunjung rumah ibadah.
                </p>

                <ol class="list-decimal list-inside space-y-2">
                    <li>Oknum meminta biaya parkir melebihi tarif resmi.</li>
                    <li>Beberapa pedagang dan jamaah dipaksa memberikan uang “keamanan”.</li>
                    <li>Masyarakat merasa terintimidasi jika menolak.</li>
                    <li>Belum ada tindakan tegas dari pihak berwenang setempat.</li>
                </ol> --}}
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="text-white mt-10 p-6" style="background-color: #4B473B;">
        <div class="max-w-6xl ml-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="font-semibold mb-2">Kanal Aduan</h4>
                <ul class="text-sm space-y-1">
                    <li>Email: Basmi@gmail.com</li>
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

    <script src="{{ asset('assets/script/burger-menu.js') }}"></script>
</body>

</html>
