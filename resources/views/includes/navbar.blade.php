<nav class="bg-blue-600 text-white shadow">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a href="{{ route('home') }}" class="font-bold text-lg">PUNGLI: GUARD</a>
        <ul class="flex gap-6 items-center">
            <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
            <li><a href="{{ route('laporan') }}" class="hover:underline">Jelajahi Aduan</a></li>
            {{--<li><a href="{{ route('aduan.create') }}" class="hover:underline">Buat Aduan</a></li>--}}
            <li><a href="{{route('about')}}" class="hover:underline">Tentang</a></li>

            {{-- Tombol Logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:underline">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
