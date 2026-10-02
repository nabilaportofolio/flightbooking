<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyBook - Jutaan Penerbangan Murah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar-item { transition: all 0.15s ease; border-radius: 10px; }
        .sidebar-item:hover { background: #eff6ff; }
        .sidebar-item.active { background: #eff6ff; }
        .hero-section {
            background: linear-gradient(135deg, #060f1e 0%, #0a1a35 35%, #0f2d5c 70%, #133580 100%);
            position: relative; overflow: hidden;
        }
        .hero-img {
            position: absolute; right: 0; top: 0; bottom: 0;
            width: 62%; object-fit: cover; object-position: center left;
            mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.15) 25%, black 55%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.15) 25%, black 55%);
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to right, rgba(6,15,30,0.96) 40%, rgba(6,15,30,0.25) 68%, transparent 88%);
        }
        .field-wrap { transition: all 0.2s; border: 1.5px solid #e5e7eb; border-radius: 14px; padding: 10px 14px; }
        .field-wrap:hover { border-color: #bfdbfe; }
        .field-wrap:focus-within { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .dest-card { transition: all 0.3s ease; }
        .dest-card:hover { transform: translateY(-5px); box-shadow: 0 24px 48px rgba(0,0,0,0.14); }
        .dest-card:hover .dest-img { transform: scale(1.07); }
        .dest-img { transition: transform 0.5s ease; }
        .airport-item:hover { background: #eff6ff; }
        .promo-gradient { background: linear-gradient(130deg, #0f2042 0%, #1a3a70 40%, #1d4ed8 100%); }
        .why-card { transition: all 0.25s; }
        .why-card:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-[230px] bg-white border-r border-gray-100 flex flex-col py-5 fixed left-0 top-0 h-full z-40 shadow-sm flex-shrink-0">

        <!-- Logo -->
        <div class="px-5 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <span class="text-white text-lg">✈</span>
                </div>
                <div>
                    <div class="font-extrabold text-gray-900 text-[17px] leading-none tracking-tight">SkyBook</div>
                    <div class="text-[10px] text-gray-400 mt-0.5 font-medium">We Make Your Travels Easy</div>
                </div>
            </div>
        </div>

        <!-- Nav -->
<nav class="flex flex-col gap-0.5 px-3 flex-1">
    <a href="/" class="sidebar-item active flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-bold text-blue-700">Pesan Tiket</span>
        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
    </a>
    <a href="/bookings" class="sidebar-item flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-medium text-gray-500">Kelola Pesanan</span>
    </a>
    <a href="/check-in" class="sidebar-item flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-medium text-gray-500">Check-in Online</span>
    </a>
    <a href="/profile" class="sidebar-item flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-medium text-gray-500">Data Penumpang</span>
    </a>
    <a href="/contact" class="sidebar-item flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-medium text-gray-500">Hubungi Kami</span>
    </a>
    <a href="/flight-status" class="sidebar-item flex items-center gap-3 px-3.5 py-3 cursor-pointer">
        <span class="text-[18px] w-6 text-center"></span>
        <span class="text-[13.5px] font-medium text-gray-500">Status Penerbangan</span>
    </a>
</nav>

        <!-- Auth -->
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
            <a href="/login" class="sidebar-item flex items-center gap-3 px-3.5 py-3 text-gray-500">
                <span class="text-[18px]"></span>
                <span class="text-[13.5px] font-medium">Masuk</span>
            </a>
            <a href="/register" class="block w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white text-[13.5px] font-bold py-3 rounded-xl text-center transition shadow-md shadow-blue-200">
                Daftar Gratis 
            </a>
            @endauth
        </div>
    </aside>

    <!-- MAIN -->
    <main class="ml-[230px] flex-1 min-h-screen">

        <!-- Top Bar -->
        <div class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
            <div>
                <h1 class="text-[16px] font-extrabold text-gray-900 leading-none">Pesan Tiket Pesawat</h1>
                <p class="text-[11.5px] text-gray-400 mt-0.5 font-medium">Temukan harga terbaik dari ratusan maskapai dunia</p>
            </div>
            <div class="flex items-center gap-2.5">
                @auth
                <div class="flex items-center gap-2 bg-blue-50 rounded-full px-3.5 py-2 border border-blue-100">
                    <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center text-white text-[10px] font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-[12px] font-semibold text-blue-700">{{ explode(' ', Auth::user()->name)[0] }}</span>
                </div>
                @endauth
                <div class="flex items-center gap-2 bg-gray-50 rounded-full px-3.5 py-2 border border-gray-100">
                    <span class="text-sm">📅</span>
                    <span class="text-[12px] font-semibold text-gray-600">{{ now()->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                </div>
            </div>
        </div>

        <!-- HERO -->
        <div class="hero-section mx-5 mt-5 rounded-3xl" style="min-height: 360px;">
            <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1400&q=85" class="hero-img" alt="Pesawat">
            <div class="hero-overlay rounded-3xl"></div>

            <div class="relative z-10 p-10" style="max-width: 560px;">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white text-[11.5px] px-4 py-2 rounded-full mb-5 border border-white/15 font-medium">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    Penerbangan Domestik & Internasional
                </div>
                <h2 class="text-[42px] font-black text-white leading-[1.1] mb-3 tracking-tight">
                    Rencanakan<br>Perjalananmu <span class="text-blue-400">✈</span>
                </h2>
                <p class="text-blue-200/90 text-[13.5px] mb-7 leading-relaxed font-medium">
                    Bandingkan harga dari 500+ maskapai dunia.<br>Hemat hingga 40% dengan SkyBook.
                </p>

                <!-- Search Card -->
                <div class="bg-white rounded-2xl p-6 shadow-2xl" style="max-width: 500px;">
                    <div class="flex items-center gap-5 mb-5 pb-4 border-b border-gray-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="trip" value="roundtrip" checked class="accent-blue-600 w-4 h-4">
                            <span class="text-[13px] font-semibold text-gray-700">Pulang-pergi</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="trip" value="oneway" class="accent-blue-600 w-4 h-4">
                            <span class="text-[13px] font-semibold text-gray-700">Sekali jalan</span>
                        </label>
                        <div class="ml-auto">
                            <select class="text-[12px] font-semibold text-gray-600 outline-none bg-blue-50 rounded-lg px-3 py-1.5 border border-blue-100 cursor-pointer">
                                <option>Economy</option>
                                <option>Business</option>
                                <option>First Class</option>
                            </select>
                        </div>
                    </div>

                    <form action="/search" method="GET">
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="relative">
                                <div class="field-wrap cursor-text">
                                    <div class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mb-1">✈ Dari</div>
                                    <input type="text" id="fromInput" name="from" placeholder="Kota asal"
                                        class="w-full text-[14px] font-bold text-gray-900 outline-none bg-transparent placeholder-gray-300"
                                        autocomplete="off" required>
                                    <input type="hidden" id="fromCode" name="from_code">
                                </div>
                                <div id="fromDropdown" class="absolute z-50 left-0 w-72 bg-white border border-gray-100 rounded-2xl shadow-2xl mt-2 hidden overflow-hidden"></div>
                            </div>
                            <div class="relative">
                                <div class="field-wrap cursor-text">
                                    <div class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mb-1">🛬 Ke</div>
                                    <input type="text" id="toInput" name="to" placeholder="Kota tujuan"
                                        class="w-full text-[14px] font-bold text-gray-900 outline-none bg-transparent placeholder-gray-300"
                                        autocomplete="off" required>
                                    <input type="hidden" id="toCode" name="to_code">
                                </div>
                                <div id="toDropdown" class="absolute z-50 left-0 w-72 bg-white border border-gray-100 rounded-2xl shadow-2xl mt-2 hidden overflow-hidden"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="field-wrap">
                                <div class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mb-1"> Tanggal Pergi</div>
                                <input type="date" name="date" class="w-full text-[14px] font-bold text-gray-900 outline-none bg-transparent" required>
                            </div>
                            <div class="field-wrap">
                                <div class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mb-1">Penumpang</div>
                                <select name="passengers" class="w-full text-[14px] font-bold text-gray-900 outline-none bg-transparent cursor-pointer">
                                    <option value="1">1 Dewasa</option>
                                    <option value="2">2 Dewasa</option>
                                    <option value="3">3 Dewasa</option>
                                    <option value="4">4 Dewasa</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 rounded-xl transition text-[14px] shadow-lg shadow-blue-200 tracking-wide">
                            &nbsp;Cari Penerbangan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- PROMO BANNER -->
        <div class="px-5 mt-5">
            <div class="promo-gradient rounded-2xl p-6 flex items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-blue-400/10 rounded-full -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-1.5 bg-white/10 text-blue-200 text-[10.5px] font-bold px-3 py-1 rounded-full mb-2.5 uppercase tracking-wider border border-white/10">
                        Penawaran Terbatas
                    </div>
                    <div class="text-white font-extrabold text-[20px] leading-tight">Hemat hingga <span class="text-yellow-300">40%</span> untuk</div>
                    <div class="text-blue-200 font-semibold text-[15px] mt-0.5">penerbangan internasional ✈</div>
                </div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="text-[72px] font-black text-white/10 leading-none select-none hidden md:block">40%</div>
                    <button class="bg-white text-blue-700 font-extrabold text-[13px] px-6 py-3 rounded-xl hover:bg-blue-50 transition shadow-lg whitespace-nowrap">
                        Lihat Promo →
                    </button>
                </div>
            </div>
        </div>

        <!-- POPULAR DESTINATIONS -->
        <div class="px-5 pt-7 pb-2">
            <div class="flex items-end justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-[18px] leading-none mb-1">Destinasi Populer</h3>
                    <p class="text-[12px] text-gray-400 font-medium">Penerbangan dari Jakarta · Harga terbaik minggu ini</p>
                </div>
                <a href="/destinations" class="text-[12.5px] text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1">
                    Lihat semua →
                </a>
            </div>

            <div class="grid grid-cols-4 gap-4">
                @foreach([
                    ['DPS', 'Bali', 'Indonesia', 'Rp 450.000', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500&q=80', '🏖️', '#f97316'],
                    ['SIN', 'Singapura', 'Singapura', 'Rp 1.200.000', 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=500&q=80', '🌆', '#ef4444'],
                    ['KUL', 'Kuala Lumpur', 'Malaysia', 'Rp 980.000', 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=500&q=80', '🏙️', '#3b82f6'],
                    ['BKK', 'Bangkok', 'Thailand', 'Rp 1.500.000', 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=500&q=80', '⛩️', '#8b5cf6'],
                    ['HND', 'Tokyo', 'Jepang', 'Rp 5.200.000', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=500&q=80', '🗼', '#ec4899'],
                    ['SYD', 'Sydney', 'Australia', 'Rp 4.800.000', 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=500&q=80', '🦘', '#14b8a6'],
                    ['LHR', 'London', 'Inggris', 'Rp 8.500.000', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=500&q=80', '🎡', '#6366f1'],
                    ['DXB', 'Dubai', 'UAE', 'Rp 3.200.000', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=500&q=80', '🏙️', '#f59e0b'],
                ] as $dest)
                <a href="/search?from=Jakarta+(CGK)&from_code=CGK&to={{ $dest[1] }}+({{ $dest[0] }})&to_code={{ $dest[0] }}&date={{ date('Y-m-d', strtotime('+7 days')) }}&passengers=1"
                   class="dest-card group block bg-white rounded-2xl overflow-hidden border border-gray-100">
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $dest[4] }}" alt="{{ $dest[1] }}" class="dest-img w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/15 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow" style="background:{{ $dest[6] }}">{{ $dest[0] }}</span>
                        </div>
                        <div class="absolute bottom-3 left-3.5">
                            <div class="text-white font-bold text-[15px] leading-none">{{ $dest[5] }} {{ $dest[1] }}</div>
                            <div class="text-white/65 text-[11px] mt-0.5">{{ $dest[2] }}</div>
                        </div>
                    </div>
                    <div class="px-4 py-3 flex items-center justify-between">
                        <div>
                            <div class="text-[10.5px] text-gray-400 font-medium">Mulai dari</div>
                            <div class="text-[15px] font-extrabold text-gray-900">{{ $dest[3] }}</div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-50 group-hover:bg-blue-600 flex items-center justify-center transition-all duration-300">
                            <span class="text-blue-500 group-hover:text-white text-sm font-bold">→</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- WHY SKYBOOK -->
        <div class="px-5 py-7 pb-10">
            <h3 class="font-extrabold text-gray-900 text-[18px] mb-5">Kenapa SkyBook?</h3>
            <div class="grid grid-cols-4 gap-4">
                @foreach([
                    ['💰', 'Harga Terjamin', 'Bandingkan harga dari 500+ maskapai sekaligus', 'bg-orange-50'],
                    ['⚡', 'Booking Cepat', 'Proses pemesanan selesai dalam 3 menit', 'bg-blue-50'],
                    ['🔒', 'Aman & Terpercaya', 'Pembayaran terenkripsi SSL 256-bit', 'bg-green-50'],
                    ['🎧', 'Support 24/7', 'Tim kami siap membantu kapan saja', 'bg-purple-50'],
                ] as [$icon, $title, $desc, $bg])
                <div class="why-card bg-white rounded-2xl p-5 border border-gray-100">
                    <div class="w-11 h-11 {{ $bg }} rounded-xl flex items-center justify-center text-2xl mb-3.5">{{ $icon }}</div>
                    <div class="font-bold text-gray-900 text-[14px] mb-1.5">{{ $title }}</div>
                    <div class="text-[12px] text-gray-400 leading-relaxed">{{ $desc }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </main>

    <script>
    const airports = [
        { code: 'CGK', name: 'Soekarno-Hatta International', city: 'Jakarta', country: 'Indonesia' },
        { code: 'HLP', name: 'Halim Perdanakusuma', city: 'Jakarta', country: 'Indonesia' },
        { code: 'DPS', name: 'Ngurah Rai International', city: 'Bali', country: 'Indonesia' },
        { code: 'SUB', name: 'Juanda International', city: 'Surabaya', country: 'Indonesia' },
        { code: 'YOG', name: 'Adisutjipto International', city: 'Yogyakarta', country: 'Indonesia' },
        { code: 'MES', name: 'Kualanamu International', city: 'Medan', country: 'Indonesia' },
        { code: 'UPG', name: 'Sultan Hasanuddin International', city: 'Makassar', country: 'Indonesia' },
        { code: 'BPN', name: 'Sultan Aji Muhammad Sulaiman', city: 'Balikpapan', country: 'Indonesia' },
        { code: 'PLM', name: 'Sultan Mahmud Badaruddin II', city: 'Palembang', country: 'Indonesia' },
        { code: 'SOC', name: 'Adisumarmo International', city: 'Solo', country: 'Indonesia' },
        { code: 'SRG', name: 'Ahmad Yani International', city: 'Semarang', country: 'Indonesia' },
        { code: 'BDO', name: 'Husein Sastranegara', city: 'Bandung', country: 'Indonesia' },
        { code: 'LOP', name: 'Lombok International', city: 'Lombok', country: 'Indonesia' },
        { code: 'SIN', name: 'Changi International', city: 'Singapura', country: 'Singapura' },
        { code: 'KUL', name: 'Kuala Lumpur International', city: 'Kuala Lumpur', country: 'Malaysia' },
        { code: 'BKK', name: 'Suvarnabhumi International', city: 'Bangkok', country: 'Thailand' },
        { code: 'DMK', name: 'Don Mueang International', city: 'Bangkok', country: 'Thailand' },
        { code: 'MNL', name: 'Ninoy Aquino International', city: 'Manila', country: 'Filipina' },
        { code: 'SGN', name: 'Tan Son Nhat International', city: 'Ho Chi Minh', country: 'Vietnam' },
        { code: 'HAN', name: 'Noi Bai International', city: 'Hanoi', country: 'Vietnam' },
        { code: 'HKG', name: 'Hong Kong International', city: 'Hong Kong', country: 'Hong Kong' },
        { code: 'HND', name: 'Haneda International', city: 'Tokyo', country: 'Jepang' },
        { code: 'NRT', name: 'Narita International', city: 'Tokyo', country: 'Jepang' },
        { code: 'KIX', name: 'Kansai International', city: 'Osaka', country: 'Jepang' },
        { code: 'ICN', name: 'Incheon International', city: 'Seoul', country: 'Korea Selatan' },
        { code: 'PEK', name: 'Capital International', city: 'Beijing', country: 'China' },
        { code: 'PVG', name: 'Pudong International', city: 'Shanghai', country: 'China' },
        { code: 'TPE', name: 'Taoyuan International', city: 'Taipei', country: 'Taiwan' },
        { code: 'DXB', name: 'Dubai International', city: 'Dubai', country: 'UAE' },
        { code: 'AUH', name: 'Abu Dhabi International', city: 'Abu Dhabi', country: 'UAE' },
        { code: 'DOH', name: 'Hamad International', city: 'Doha', country: 'Qatar' },
        { code: 'RUH', name: 'King Khalid International', city: 'Riyadh', country: 'Arab Saudi' },
        { code: 'JED', name: 'King Abdulaziz International', city: 'Jeddah', country: 'Arab Saudi' },
        { code: 'LHR', name: 'Heathrow', city: 'London', country: 'Inggris' },
        { code: 'LGW', name: 'Gatwick', city: 'London', country: 'Inggris' },
        { code: 'EDI', name: 'Edinburgh Airport', city: 'Edinburgh', country: 'Skotlandia' },
        { code: 'MAN', name: 'Manchester Airport', city: 'Manchester', country: 'Inggris' },
        { code: 'CDG', name: 'Charles de Gaulle', city: 'Paris', country: 'Prancis' },
        { code: 'AMS', name: 'Amsterdam Schiphol', city: 'Amsterdam', country: 'Belanda' },
        { code: 'FRA', name: 'Frankfurt Airport', city: 'Frankfurt', country: 'Jerman' },
        { code: 'MUC', name: 'Munich Airport', city: 'Munich', country: 'Jerman' },
        { code: 'MAD', name: 'Adolfo Suarez Barajas', city: 'Madrid', country: 'Spanyol' },
        { code: 'FCO', name: 'Leonardo da Vinci', city: 'Roma', country: 'Italia' },
        { code: 'IST', name: 'Istanbul Airport', city: 'Istanbul', country: 'Turki' },
        { code: 'SYD', name: 'Kingsford Smith', city: 'Sydney', country: 'Australia' },
        { code: 'MEL', name: 'Melbourne Airport', city: 'Melbourne', country: 'Australia' },
        { code: 'AKL', name: 'Auckland Airport', city: 'Auckland', country: 'Selandia Baru' },
        { code: 'JFK', name: 'John F. Kennedy', city: 'New York', country: 'Amerika Serikat' },
        { code: 'LAX', name: 'Los Angeles International', city: 'Los Angeles', country: 'Amerika Serikat' },
        { code: 'SFO', name: 'San Francisco International', city: 'San Francisco', country: 'Amerika Serikat' },
        { code: 'YYZ', name: 'Pearson International', city: 'Toronto', country: 'Kanada' },
        { code: 'JNB', name: 'O.R. Tambo International', city: 'Johannesburg', country: 'Afrika Selatan' },
        { code: 'CAI', name: 'Cairo International', city: 'Kairo', country: 'Mesir' },
    ];

    function setupAutocomplete(inputId, dropdownId, codeId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        if (!input || !dropdown) return;
        input.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            if (q.length < 1) { dropdown.classList.add('hidden'); return; }
            const results = airports.filter(a =>
                a.city.toLowerCase().includes(q) ||
                a.code.toLowerCase().includes(q) ||
                a.name.toLowerCase().includes(q) ||
                a.country.toLowerCase().includes(q)
            ).slice(0, 6);
            if (!results.length) { dropdown.classList.add('hidden'); return; }
            dropdown.innerHTML = results.map(a => `
                <div class="airport-item flex items-center gap-3 px-4 py-3 cursor-pointer border-b border-gray-50 last:border-0 transition"
                    onmousedown="selectAirport('${inputId}','${dropdownId}','${codeId}','${a.code}','${a.city}')">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-[11px] font-black text-blue-600">${a.code}</span>
                    </div>
                    <div>
                        <div class="text-[13.5px] font-semibold text-gray-800">${a.city} <span class="text-gray-300">(${a.code})</span></div>
                        <div class="text-[11px] text-gray-400">${a.name} · ${a.country}</div>
                    </div>
                </div>
            `).join('');
            dropdown.classList.remove('hidden');
        });
        input.addEventListener('blur', () => setTimeout(() => dropdown.classList.add('hidden'), 150));
    }

    function selectAirport(inputId, dropdownId, codeId, code, city) {
        document.getElementById(inputId).value = `${city} (${code})`;
        document.getElementById(codeId).value = code;
        document.getElementById(dropdownId).classList.add('hidden');
    }

    setupAutocomplete('fromInput', 'fromDropdown', 'fromCode');
    setupAutocomplete('toInput', 'toDropdown', 'toCode');
    </script>
</body>
</html>