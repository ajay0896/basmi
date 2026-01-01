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
            background-image: url('./assets/img/bg_about.png');
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
            Tentang Kami
        </h1>

        <nav class="ml-auto">
            <a href="{{route('home')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Beranda</a>
            <a href="{{route('aduan.show')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Aduanku</a>
            <a href="{{route('laporan')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Jelajahi aduan</a>
            <!-- <a href="#"
                class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
                Daftar / Masuk
            </a> -->
        </nav>
    </header>
    <!-- About Section -->
    <section class=" py-6" id="about">
        <div class="max-w-5xl mx-auto text-center px-40">
            <h2 class="text-3xl font-bold text-teal-800 mb-4">Basmi</h2>
            <p class="text-gray-700 leading-relaxed text-center mb-8">
                Basmi adalah aplikasi pelaporan pungutan liar berbasis teknologi Artificial Intelligence (AI)
                yang hadir untuk menciptakan layanan publik yang lebih bersih, transparan, dan aman.
                <br>
                Kami memahami bahwa banyak masyarakat enggan melaporkan praktik pungli karena rasa takut atau tidak
                percaya pada mekanisme pengawasan.
                Oleh karena itu, Basmi dirancang agar siapa pun dapat melapor secara anonim, cepat, dan
                terenkripsi, tanpa rasa khawatir terhadap intimidasi.
            </p>
        </div>

        <div class="max-w-5xl mx-auto text-center px-6">
            <!-- 3 Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 ">
                <div class=" text-white rounded-lg mt-4 text-whitep-6  ">
                    <div class="text-4xl flex justify-center text-teal-700 mb-4">
                        <img src={{asset("assets/img/circle_logo_1.png")}} class="w-20" alt=""="">
                    </div>
                    <h3 class="font-bold text-lg mb-2">Lapor</h3>
                    <p class="text-white text-sm">
                        Kanal aduan masyarakat Bandung. Adukan indikasi pungli dengan mudah, aman, dan terverifikasi.
                    </p>
                </div>
                <div class="text-white rounded-lg mt-4 p-6">
                    <div class="text-4xl flex justify-center text-teal-700 mb-4">
                        <img src="{{asset('assets/img/circle_logo_2.png')}}" class="w-20" alt=""="">
                    </div>
                    <h3 class="font-bold text-lg mb-2">Nuturkeun</h3>
                    <p class="text-white text-sm">
                        Kami hadir 24 jam untuk menindaklanjuti laporan masyarakat. Tindakan cepat dan transparan.
                    </p>
                </div>
                <div class="text-white rounded-lg  p-6">
                    <div class="text-4xl flex justify-center text-teal-700 mb-4">
                        <img src="{{asset("assets/img/circle_logo_3.png")}}" class="w-20" alt=""="">
                    </div>
                    <h3 class="font-bold text-lg mb-2">Rampung</h3>
                    <p class="text-white text-sm">
                        Semua laporan kami pastikan ditindaklanjuti hingga selesai. Wujudkan Indonesia bebas pungli.
                    </p>
                </div>
            </div>
        </div>

</body>

</html>
