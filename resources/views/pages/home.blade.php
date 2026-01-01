

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basmi - Bersih Aksi Suap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
      background-image: url('./assets/img/bg_home.png');
      background-size: cover;       /* biar menyesuaikan layar */
      background-position: center;  /* fokus di tengah */
      background-repeat: no-repeat; /* jangan diulang */
      background-attachment: fixed; /* biar efek parallax */
    }
  </style>
</head>

<body class="font-sans">

    <!-- Header -->
    <header class="bg-teal-800 text-white p-4 flex justify-between items-center shadow-md relative">
        <h1 class="text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">
            Basmi
        </h1>

        <nav class="ml-auto">
            <a href="{{route('about')}}" class="font-bold hover:text-yellow-300 transition">Tentang</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
             @csrf
            <button type="submit" class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
            Logout
          </button>
          </form>
        </nav>
    </header>
    <!-- Search Section -->
    <form action="{{ route('laporan') }}" method="GET">
    <section class="py-6 text-center ">
        <h2 class="text-lg font-semibold mb-2">WILUJENG SUMPING WARGI BANDUNG!!!</h2>
        <p class="text-gray-600 mb-4">Bersih Aksi Suap, Musnahkeun Indisiplin</p>
        <div class="flex justify-center">
            <input type="text" placeholder="Jelajahi Aduan" value="{{ request('search') }}"
            name="search"
            class="w-1/4 p-2 rounded-l-lg border border-gray-300 focus:outline-none">
            <button class="bg-teal-800 text-white px-4 rounded-r-lg">Cari</button>
        </div>
    </section>
</form>

    <!-- Tabs Aduan -->
    <section class="max-w-6xl mx-auto mt-8 p-4 bg-white bg-opacity-90 rounded-lg shadow">
        <div class="text-center mt-12 mb-12">
            <h2 class="text-xl font-semibold text-teal-800">Buat Aduan</h2>
            <p class="mt-2 text-gray-600">
                Laporkan keluhan atau masalah pungutan liar yang Anda temui di Kabupaten Bandung melalui form aduan
                online.
            </p>
            <a href="{{route('aduan.form')}}"
                class="inline-flex items-center px-6 py-3 mt-6 text-white bg-teal-800 rounded-lg shadow hover:bg-gray-600">
                <span class="text-lg font-medium">+ Buat Aduan</span>
            </a>
        </div>



        <!-- Cards Aduan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($laporans as $item)
        <a href="{{ route('aduan.detail', $item->id) }}" class="block border rounded-lg shadow-sm p-4 hover:shadow-md transition">
            <div class="border rounded-lg shadow-sm p-4">
                <img src="{{ asset('storage/'.$item->foto) }}" alt="aduan" class="max-w-30 rounded-lg mb-3">
                <h3 class="text-sm font-bold">{{$item->kecamatan->nama}},{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->isoFormat('D MMMM YYYY') }} </h3>
                <p class="text-gray-600 text-sm">{{ $item->deskripsi_kejadian }}</p>
                <span class="text-xs text-gray-500">0 Orang Menandai</span>
            </div>
             </a>
             @empty
            <p class="text-center text-gray-500 py-6">Belum ada aduan.</p>
             @endforelse
        </div>

        <div class="text-center mt-6">
            <a href="{{route('laporan')}}" class="text-teal-700 hover:underline">Lihat Aduan Lainnya ></a>
        </div>

        <!-- Zona Pungli -->
        <div class="mt-10 p-6 border rounded-lg text-center">
            <h2 class="text-lg font-semibold mb-4">Zona Persebaran Pungli di Kabupaten Bandung</h2>
            <div class="h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                <img src="assets/img/maps_.png" class="h-64" alt="" srcset="">
            </div>
        </div>
    </section>

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

</body>

</html>
