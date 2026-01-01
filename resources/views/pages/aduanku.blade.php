<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basmi - Bersih Aksi Suap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            height: 100vh;
            background-image: url('./assets/img/bg_aduanq.png');
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

    <!-- Header -->
    <header class="bg-teal-800 text-white p-4 flex justify-between items-center shadow-md relative">
        <h1 class="text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">
            Aduanku
        </h1>

        <nav class="ml-auto">
            <a href="{{route('home')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Beranda</a>
            <a href="{{route('about')}}" class="ml-2 font-bold hover:text-yellow-300 transition">tentang Kami</a>
            <a href="{{route('laporan')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Jelajahi aduan</a>
            <!-- <a href="#"
                class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
                Daftar / Masuk
            </a> -->
        </nav>
    </header>
    <!-- aduanku Section -->
    <!-- Content -->
    <section class=" py-12 relative">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Filter Sidebar -->
            <aside class="md:col-span-1  shadow rounded-lg p-6 hover:shadow-xl transition">
                <h3 class="font-bold text-teal-800 mb-4">Filter</h3>

                <!-- Tanggal -->
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date"
                    class="w-full border rounded px-3 py-2 mb-6 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                <!-- Status -->
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="text-teal-600"> <span>Menunggu</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="text-teal-600"> <span>Diproses</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="text-teal-600"> <span>Selesai</span>
                    </label>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="md:col-span-3">
                <!-- Tabs -->
                <div class="bg-white shadow rounded-lg p-4 flex space-x-4 mb-6 hover:shadow-xl transition">
                    <button class="flex-1 py-2 px-4 bg-teal-600 text-white rounded-md font-semibold">Aduanku</button>
                </div>

                <!-- List Aduan -->
                <div class="space-y-4">
                     @forelse($laporans as $item)
                    <!-- Card Aduan -->
                    <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
                        <h4 class="font-bold text-lg text-teal-700">Aduan #{{ $item->kode_laporan }}</h4>
                        <p class="text-gray-600 text-sm mt-2">
                            {{ $item->deskripsi }}
                            Status saat ini:
                            @php
                        $statusColors = [
                            'menunggu' => 'bg-gray-500',
                            'diproses' => 'bg-yellow-500',
                            'selesai'  => 'bg-green-600',
                          ];
                         @endphp
                          <span class="text-xs text-white px-2 py-1 rounded {{ $statusColors[$item->status] ?? 'bg-gray-400' }}">
                            {{($item->status) }}
                         </span>
                        </p>
                        <p class="text-xs text-gray-500 mt-2">Tanggal: {{$item->tanggal_kejadian->isoFormat('D MMMM YYYY')}}</p>
                    </div>
                     @empty
                     <p class="text-center text-gray-500 py-6">Belum ada aduan.</p>
                     @endforelse
                 <a href="{{route('aduan.form')}}">
                       <button class="mt-4 w-full bg-teal-600 text-white py-2 rounded-md hover:bg-teal-700 transition">
                        Buat Aduan Baru
                       </button>
                </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
