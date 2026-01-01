

{{-- <div class="bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Data Diri Anda Akan Disimpan Secara Anonim</h2>

    <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
         <input type="text" name="nama" placeholder="Nama Lengkap"
         class="border p-2 rounded"
         value="{{ old('nama', session('aduan_data.nama')) }}" required>
         <input type="text" name="nik" placeholder="NIK"
         class="border p-2 rounded"
         value="{{ old('nik', session('aduan_data.nik')) }}" required>
         <input type="text" name="no_hp" placeholder="Nomor HP"
         class="border p-2 rounded"
         value="{{ old('no_hp', session('aduan_data.no_hp')) }}" required>
         <input type="email" name="email" placeholder="Email"
         class="border p-2 rounded"
         value="{{ old('email', session('aduan_data.email')) }}" required>
          </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-300 rounded">Sebelumnya</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Selanjutnya</button>
        </div>
    </form>
</div> --}}

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
            background-image: url('./assets/img/bg_home.png');
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
        <h2 class="text-xl font-bold mb-6 text-center">DATA DIRI ANDA AKAN DISIMPAN DAN DILAPORKAN SECARA ANONIM</h2>
        <p class="text-center text-gray-600 mb-10">Silahkan isi untuk memasukkan data diri pelaporan aduan.</p>
        <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <!-- Nama -->
        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Nama</label>
            <input type="text" name="nama"  class="border w-full border-gray-300 rounded-b-lg p-3 focus:ring focus:ring-teal-300"
                placeholder="Silahkan Masukkan Nama Lengkap Anda" value="{{ old('nama', session('aduan_data.nama')) }}" required>
        </div>

        <!-- NIK -->
        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">NIK</label>
            <input type="text" name="nik" class="border w-full border-gray-300 rounded-b-lg p-3 focus:ring focus:ring-teal-300"
                placeholder="Silahkan Masukkan NIK KTP Anda"  value="{{ old('nik', session('aduan_data.nik')) }}" required>
        </div>

        <!-- Nomor Handphone -->
        <div class="mb-6">
            <label class="block bg-[#4B473B] text-white px-4 py-2 rounded-t-lg">Nomor Handphone</label>
            <input type="text" name="no_hp" class="border w-full border-gray-300 rounded-b-lg p-3 focus:ring focus:ring-teal-300"
                placeholder="Silahkan Masukkan Nomor Handphone Anda" value="{{ old('no_hp', session('aduan_data.no_hp')) }}" required>
        </div>

        <div class="flex justify-between mb-6">
            <a href="{{ route('aduan.form') }}" class="bg-gray-300 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-400 transition">Kembali</a>
            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg shadow hover:bg-teal-700 transition">Selanjutnya</button>
        </div>
        </form>

    </main>



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

