
{{--<div class="max-w-md mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

    <form action="{{ route('register.process') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">No Handphone</label>
            <input type="text" name="no_handphone" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Daftar</button>
    </form>
</div>--}}

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
            Daftar
        </h1>

        <nav class="ml-auto">
            <a href="{{route('home')}}" class="ml-2 font-bold hover:text-yellow-300 transition">Beranda</a>
            <a href="{{route('about')}}" class="ml-2 font-bold hover:text-yellow-300 transition">tentang Kami</a>
            <!-- <a href="#"
                class="ml-4 font-bold bg-white text-teal-700 px-3 py-1 rounded-lg hover:bg-yellow-300 hover:text-teal-800 transition">
                Daftar / Masuk
            </a> -->
        </nav>
    </header>

        <div class="flex items-center justify-center min-h-screen font-sans">
            <!-- Card Login -->
            <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md hover:shadow-2xl transition">
                <!-- Judul -->
                <h2 class="text-2xl font-bold text-center text-teal-700 mb-6">Daftar ka Basmi</h2>

                <!-- Form -->
                <form  action="{{ route('register.process') }}" method="POST">
                     @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nama</label>
                        <input type="text" placeholder="Masukkan email" name="name"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                        <input type="email" placeholder="Masukkan email" name="email"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                        <input type="password" placeholder="Masukkan password" name="password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                    </div>


                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full bg-teal-700 text-white py-2 rounded-lg font-semibold hover:bg-teal-800 transition">Unggah</button>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="px-3 text-gray-500 text-sm">atau</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Tombol Google -->


                <!-- Link Register -->
                <p class="text-center text-sm text-gray-600 mt-6">Sudah punya akun?
                    <a href="{{route('login')}}" class="text-teal-600 font-semibold hover:underline">Asup ka dieu</a>
                </p>
            </div>
        </div>
</body>

</html>



