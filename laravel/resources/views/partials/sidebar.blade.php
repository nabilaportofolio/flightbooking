<aside class="w-[230px] bg-white border-r border-gray-100 flex flex-col py-5 fixed left-0 top-0 h-full z-40 shadow-sm flex-shrink-0">

    <div class="px-5 mb-8">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                <span class="text-white text-lg">✈</span>
            </div>
            <div>
                <div class="font-extrabold text-gray-900 text-[17px] leading-none tracking-tight">SkyBook</div>
                <div class="text-[10px] text-gray-400 mt-0.5 font-medium">We Make Your Travels Easy</div>
            </div>
        </a>
    </div>

    <nav class="flex flex-col gap-0.5 px-3 flex-1">
    @foreach([
        ['/', 'home', 'Pesan Tiket'],
        ['/bookings', 'bookings', 'Kelola Pesanan'],
        ['/check-in', 'check-in', 'Check-in Online'],
        ['/profile', 'profile', 'Data Penumpang'],
        ['/contact', 'contact', 'Hubungi Kami'],
        ['/flight-status', 'flight-status', 'Status Penerbangan'],
    ] as [$href, $page, $label])
    @php $isActive = ($activePage ?? 'home') === $page; @endphp
    <a href="{{ $href }}" class="flex items-center gap-3 px-3.5 py-3 cursor-pointer rounded-xl transition {{ $isActive ? 'bg-blue-50' : 'hover:bg-blue-50' }}">
        <span class="text-[13.5px] {{ $isActive ? 'font-bold text-blue-700' : 'font-medium text-gray-500' }}">{{ $label }}</span>
        @if($isActive)<div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>@endif
    </a>
    @endforeach
</nav>

    <div class="border-t border-gray-100 mx-4 my-4"></div>

    <div class="px-3 space-y-1">
        @auth
        <div class="flex items-center gap-2.5 px-3 py-2.5 bg-blue-50 rounded-xl mb-2">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-[13px] font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</div>
                <div class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button class="w-full text-xs text-red-400 hover:text-red-600 hover:bg-red-50 py-2 rounded-lg transition text-center">← Keluar</button>
        </form>
        @else
        <a href="/login" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-gray-500 hover:bg-blue-50 transition">
            <span class="text-[18px]"></span>
            <span class="text-[13.5px] font-medium">Masuk</span>
        </a>
        <a href="/register" class="block w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white text-[13.5px] font-bold py-3 rounded-xl text-center transition shadow-md shadow-blue-200">
            Daftar Gratis 
        </a>
        @endauth
    </div>
</aside>