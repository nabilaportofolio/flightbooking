<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Destinasi - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .dest-card { transition: all 0.3s ease; }
        .dest-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .dest-card:hover .dest-img { transform: scale(1.08); }
        .dest-img { transition: transform 0.5s ease; }
        .tab-btn { transition: all 0.2s; }
        .tab-btn.active { background: #1d4ed8; color: white; }
        .tab-btn:not(.active) { background: white; color: #64748b; border: 1px solid #e2e8f0; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-[#0f172a] px-8 py-4 flex items-center justify-between sticky top-0 z-50">
        <a href="/" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-black text-sm">✈</div>
            <span class="font-extrabold text-white text-lg tracking-tight">SkyBook</span>
        </a>
        <div class="flex items-center gap-6 text-sm text-slate-400">
            <a href="/" class="hover:text-white">Beranda</a>
            <a href="#" class="hover:text-white">Flights</a>
            <a href="#" class="hover:text-white">Hotels</a>
        </div>
        <div class="flex gap-2">
            @auth
            <span class="text-sm text-slate-300 font-medium">{{ Auth::user()->name }}</span>
            @else
            <a href="/login" class="text-sm text-slate-300 hover:text-white px-3 py-1.5">Login</a>
            <a href="/register" class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded-lg">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-[#0f172a] to-[#1e3a6b] px-8 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="text-blue-400 text-sm font-semibold mb-2">✈ Dari Jakarta</div>
            <h1 class="text-4xl font-extrabold text-white mb-2">Jelajahi Semua Destinasi</h1>
            <p class="text-slate-400">{{ count($destinations) }} destinasi tersedia · Harga terbaik dijamin</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Filter Tabs --}}
        <div class="flex items-center gap-2 mb-6 flex-wrap">
            <button class="tab-btn active px-4 py-2 rounded-xl text-sm font-semibold" onclick="filterDest('all', this)">Semua</button>
            @foreach(['Indonesia', 'Asia', 'Australia', 'Eropa', 'Timur Tengah', 'Amerika'] as $region)
            <button class="tab-btn px-4 py-2 rounded-xl text-sm font-semibold" onclick="filterDest('{{ $region }}', this)">{{ $region }}</button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-4 gap-5" id="destGrid">
            @foreach($destinations as $dest)
            <a href="/search?from=Jakarta+(CGK)&from_code=CGK&to={{ $dest[1] }}+({{ $dest[0] }})&to_code={{ $dest[0] }}&date={{ date('Y-m-d', strtotime('+7 days')) }}&passengers=1"
               class="dest-card group block bg-white rounded-2xl overflow-hidden border border-slate-100"
               data-region="{{ $dest[7] }}">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ $dest[4] }}" alt="{{ $dest[1] }}" class="dest-img w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>
                    <div class="absolute top-3 left-3">
                        <div class="text-white text-[10px] font-black px-2 py-0.5 rounded-md shadow" style="background: {{ $dest[6] }}">{{ $dest[0] }}</div>
                    </div>
                    <div class="absolute bottom-3 left-3">
                        <div class="text-white font-bold text-sm leading-none">{{ $dest[5] }} {{ $dest[1] }}</div>
                        <div class="text-white/65 text-xs mt-0.5">{{ $dest[2] }}</div>
                    </div>
                    <div class="absolute top-3 right-3 bg-black/30 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $dest[7] }}</div>
                </div>
                <div class="px-3 py-3 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-400">Mulai dari</div>
                        <div class="text-sm font-extrabold text-slate-800">{{ $dest[3] }}</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-50 group-hover:bg-blue-600 flex items-center justify-center transition-colors">
                        <span class="text-blue-500 group-hover:text-white text-xs font-bold">→</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div id="emptyState" class="hidden text-center py-16">
            <div class="text-4xl mb-3">✈️</div>
            <div class="text-slate-500 font-medium">Tidak ada destinasi ditemukan</div>
        </div>
    </div>

    <script>
    function filterDest(region, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cards = document.querySelectorAll('#destGrid a');
        let visible = 0;
        cards.forEach(card => {
            const show = region === 'all' || card.dataset.region === region;
            card.style.display = show ? 'block' : 'none';
            if (show) visible++;
        });

        document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
    }
    </script>
</body>
</html>