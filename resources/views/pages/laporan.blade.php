

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
        <h1 class="text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">
            Jelajahi Aduan
        </h1>

        <nav class="ml-auto">
            <a href="{{route('home')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Beranda</a>
            <a href="{{route('about')}}" class="font-bold hover:text-yellow-300 transition">Tentang</a>
            <a href="{{route('aduan.show')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Aduanku</a>
        </nav>
    </header>

    <!-- Pencarian -->
    <form action="{{ route('laporan') }}" method="GET" >
    <section class="max-w-7xl px-12 py-4 mt-12">
        <div class="flex">
            <input type="text" placeholder="Contoh: bsm345645" name="search"  value="{{ request('search') }}"
                class="w-full border border-gray-300 px-3 py-2 rounded-l focus:ring-2 focus:ring-teal-500 outline-none">
            <button class="bg-teal-700 text-white px-4 py-2 rounded-r hover:bg-teal-600">Cari</button>
        </div>
    </section>

    <section class="max-w-7xl mx-8 px-6">
        <div class="flex justify-between items-center mb-4">
            {{-- Dropdown Kecamatan --}}
            <div>
                <select name="kecamatan_id" onchange="this.form.submit()" class="border px-3 py-2 rounded">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}"
                            {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                            {{ $kecamatan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown Sort (Terbaru/Terlama) --}}
            <div>
                <select name="sort" onchange="this.form.submit()" class="border p-2 rounded">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>

        </div>
    </section>
</form>
    <!-- List Aduan -->
    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white bg-opacity-90 shadow-lg rounded">
        <!-- Judul -->
        <h2 class="text-xl font-semibold mb-2">Semua Aduan</h2>
        <p class="text-sm text-gray-500 mb-4">Terdapat {{ $laporans->total() }} total aduan</p>

        <!-- List Aduan -->
       <div class="divide-y">
       @forelse($laporans as $item)
        <!-- Aduan Item -->
        <a href="{{ route('aduan.detail', $item->id) }}"
           class="py-4 flex gap-4 hover:bg-gray-50 transition rounded-lg block">

            <!-- Foto -->
            <img src="{{ asset('storage/' . $item->foto) }}"
                 alt="lampiran"
                 class="w-32 h-24 object-cover rounded border">

            <!-- Konten -->
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-blue-600 font-semibold">#{{ $item->kode_laporan }}</span>
                        <span class="text-gray-500 text-sm ml-2">
                            {{ $item->lokasi_kejadian }}, {{ $item->tanggal_kejadian->isoFormat('D MMMM YYYY') }}
                        </span>
                    </div>
                    @php
                        $statusColors = [
                            'menunggu' => 'bg-gray-500',
                            'diproses' => 'bg-yellow-500',
                            'selesai'  => 'bg-green-600',
                        ];
                    @endphp
                    <span class="text-xs text-white px-2 py-1 rounded {{ $statusColors[$item->status] ?? 'bg-gray-400' }}">
                        {{ $item->status }}
                    </span>
                </div>

                <p class="mt-2 text-gray-700">
                    {{ $item->deskripsi_kejadian }}
                </p>

                <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                    <span>3 orang menandai aduan</span>
                </div>
            </div>
        </a>
             @empty
            <p class="text-center text-gray-500 py-6">Belum ada aduan.</p>
             @endforelse
          </div>




        <!-- Pagination -->
        <section class="max-w-7xl mx-auto px-6 py-6">
              {{ $laporans->links() }}
        </section>
    </div>

    <!-- Footer -->
    <footer class="text-white mt-10 p-6" style="background-color: #4B473B;">
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
