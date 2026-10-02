<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $from ?? 'Jakarta' }} → {{ $to ?? 'Tujuan' }} - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .flight-card:hover { box-shadow: 0 8px 30px rgba(59,130,246,0.12); transform: translateY(-1px); }
        .flight-card { transition: all 0.2s; }
        .tab-active { background: #1d4ed8; color: white; }
        .tab-inactive { background: white; color: #374151; border: 1px solid #e5e7eb; }
        .airline-logo { background: linear-gradient(135deg, #1e3a5f, #2563eb); }
        .time-slot { border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 6px; text-align: center; font-size: 12px; color: #4b5563; cursor: pointer; transition: all 0.15s; user-select: none; }
        .time-slot:hover { border-color: #93c5fd; color: #2563eb; }
        .time-slot.selected { border-color: #2563eb; background: #eff6ff; color: #1d4ed8; font-weight: 700; }
        .flight-card.hidden-flight { display: none; }
        #no-results { display: none; }
    </style>
</head>
<body class="bg-gray-50">

    {{-- TOP NAVBAR --}}
    <nav class="bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-black text-sm">✈</div>
            <span class="font-extrabold text-gray-800 text-lg">SkyBook</span>
        </a>
        <div class="flex items-center gap-4 text-sm text-gray-500">
            <a href="#" class="hover:text-blue-600">Explore</a>
            <a href="#" class="hover:text-blue-600">Flights</a>
            <a href="#" class="hover:text-blue-600">Hotels</a>
        </div>
        <div class="flex gap-2">
            @auth
                <span class="text-sm text-gray-600 font-medium">{{ Auth::user()->name }}</span>
            @else
                <a href="/login" class="text-sm text-gray-600 hover:text-blue-600 px-3 py-1.5">Masuk</a>
                <a href="/register" class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-700">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- SEARCH BAR --}}
    <div class="bg-blue-700 px-6 py-4">
        <div class="max-w-5xl mx-auto">
            <form action="/search" method="GET">
                <div class="bg-white rounded-2xl px-5 py-3 flex items-center gap-4 shadow-lg">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-400 mb-0.5">Dari</div>
                        <input type="text" name="from" value="{{ $from }}" class="w-full text-sm font-bold text-gray-800 outline-none">
                        <input type="hidden" name="from_code" value="{{ $from_code ?? '' }}">
                    </div>
                    <div class="text-gray-300 text-xl font-light">⇄</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-400 mb-0.5">Ke</div>
                        <input type="text" name="to" value="{{ $to }}" class="w-full text-sm font-bold text-gray-800 outline-none">
                        <input type="hidden" name="to_code" value="{{ $to_code ?? '' }}">
                    </div>
                    <div class="w-px h-8 bg-gray-100"></div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-400 mb-0.5">Tanggal</div>
                        <input type="date" name="date" value="{{ $date }}" class="w-full text-sm font-bold text-gray-800 outline-none bg-transparent">
                    </div>
                    <div class="w-px h-8 bg-gray-100"></div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-400 mb-0.5">Penumpang</div>
                        <select name="passengers" class="w-full text-sm font-bold text-gray-800 outline-none bg-transparent">
                            <option value="1" {{ $passengers == 1 ? 'selected' : '' }}>1 Dewasa</option>
                            <option value="2" {{ $passengers == 2 ? 'selected' : '' }}>2 Dewasa</option>
                            <option value="3" {{ $passengers == 3 ? 'selected' : '' }}>3 Dewasa</option>
                            <option value="4" {{ $passengers == 4 ? 'selected' : '' }}>4 Dewasa</option>
                            <option value="5" {{ $passengers == 5 ? 'selected' : '' }}>2 Dewasa 1 Anak</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition flex-shrink-0">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- PRICE TABS --}}
    <div class="bg-white border-b border-gray-100 px-6 py-3">
        <div class="max-w-5xl mx-auto flex gap-3">
            @php
                $hargaAngka = array_map(fn($f) => (int) preg_replace('/[^0-9]/', '', $f['harga']), $flights);
                $minHarga = !empty($hargaAngka) ? min($hargaAngka) : 0;
                $maxHarga = !empty($hargaAngka) ? max($hargaAngka) : 0;
                $minDurasi = !empty($flights) ? $flights[0]['durasi'] : '-';
                $formatRp = fn($n) => 'Rp ' . number_format($n, 0, ',', '.');
            @endphp
            <div class="tab-active rounded-xl px-5 py-2 text-sm font-bold cursor-pointer">
                <div class="text-xs opacity-80 mb-0.5">Terbaik</div>
                <div class="font-extrabold">{{ $formatRp($minHarga) }}</div>
                <div class="text-xs opacity-70">{{ $minDurasi }}</div>
            </div>
            <div class="tab-inactive rounded-xl px-5 py-2 text-sm cursor-pointer hover:bg-gray-50">
                <div class="text-xs text-gray-400 mb-0.5">Termurah</div>
                <div class="font-extrabold text-gray-800">{{ $formatRp($minHarga) }}</div>
                <div class="text-xs text-gray-400">{{ $minDurasi }}</div>
            </div>
            <div class="tab-inactive rounded-xl px-5 py-2 text-sm cursor-pointer hover:bg-gray-50">
                <div class="text-xs text-gray-400 mb-0.5">Tercepat</div>
                <div class="font-extrabold text-gray-800">{{ $formatRp($maxHarga) }}</div>
                <div class="text-xs text-gray-400">{{ $minDurasi }}</div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-5xl mx-auto px-4 py-6 flex gap-6">

        {{-- FILTER SIDEBAR --}}
        <div class="w-56 flex-shrink-0">
            <div class="bg-white rounded-2xl p-4 border border-gray-100 sticky top-24">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 text-sm">Filter</h3>
                    <button onclick="resetFilters()" class="text-xs text-blue-600 hover:underline">Reset</button>
                </div>

                {{-- Stops --}}
                <div class="mb-5">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Pemberhentian</div>
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="checkbox" checked class="accent-blue-600 w-4 h-4 filter-stop" value="langsung" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">Langsung</span>
                    </label>
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="checkbox" class="accent-blue-600 w-4 h-4 filter-stop" value="1transit" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">1 Transit</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="accent-blue-600 w-4 h-4 filter-stop" value="2transit" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">2+ Transit</span>
                    </label>
                </div>

                {{-- Airlines --}}
                <div class="mb-5">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Maskapai</div>
                    @foreach($flights as $f)
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="checkbox" checked class="accent-blue-600 w-4 h-4 filter-airline"
                            value="{{ $f['maskapai'] }}" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">{{ $f['maskapai'] }}</span>
                    </label>
                    @endforeach
                </div>

                {{-- Departure Time --}}
                <div class="mb-5">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Waktu Berangkat</div>
                    <div class="grid grid-cols-2 gap-1.5">
                        <div class="time-slot" data-range="00-06" onclick="toggleTime(this)">00-06</div>
                        <div class="time-slot" data-range="06-12" onclick="toggleTime(this)">06-12</div>
                        <div class="time-slot" data-range="12-18" onclick="toggleTime(this)">12-18</div>
                        <div class="time-slot" data-range="18-24" onclick="toggleTime(this)">18-24</div>
                    </div>
                </div>

                {{-- Baggage --}}
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Bagasi</div>
                    <label class="flex items-center gap-2 mb-2 cursor-pointer">
                        <input type="checkbox" class="accent-blue-600 w-4 h-4 filter-baggage" value="include" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">Termasuk bagasi</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="accent-blue-600 w-4 h-4 filter-baggage" value="exclude" onchange="applyFilters()">
                        <span class="text-sm text-gray-700">Tanpa bagasi</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- FLIGHT LIST --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">
                    <span id="result-count" class="font-bold text-gray-800">{{ count($flights) }} penerbangan</span> ditemukan untuk
                    <span class="font-semibold text-blue-600">{{ $from }}</span> →
                    <span class="font-semibold text-blue-600">{{ $to }}</span>
                </p>
                <select onchange="sortFlights(this.value)" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 outline-none text-gray-600 bg-white">
                    <option value="best">Urutkan: Terbaik</option>
                    <option value="cheap">Urutkan: Termurah</option>
                    <option value="fast">Urutkan: Tercepat</option>
                </select>
            </div>

            <div id="flight-list" class="flex flex-col gap-3">
                @foreach($flights as $flight)
                @php
                    $hargaNum = (int) preg_replace('/[^0-9]/', '', $flight['harga']);
                    $jamNum = (int) explode(':', str_replace(['j ', 'm'], [':', ''], $flight['berangkat']))[0];
                @endphp
                <div class="flight-card bg-white border border-gray-100 rounded-2xl overflow-hidden"
                     data-maskapai="{{ $flight['maskapai'] }}"
                     data-stop="langsung"
                     data-jam="{{ $jamNum }}"
                     data-harga="{{ $hargaNum }}"
                     data-durasi="{{ $flight['durasi'] }}">

                    {{-- Main row --}}
                    <div class="p-5 flex items-center gap-4">

                        {{-- Airline Logo --}}
                        <div class="flex-shrink-0 text-center w-20">
                           @php
$airlineLogo = [
    'Garuda Indonesia'   => asset('images/airlines/garuda.png'),
    'Lion Air'           => asset('images/airlines/lion-air.png'),
    'Citilink'           => asset('images/airlines/citilink.png'),
    'Batik Air'          => asset('images/airlines/batik-air.png'),
    'Singapore Airlines' => asset('images/airlines/singapore-airlines.png'),
    'AirAsia'            => asset('images/airlines/air-asia.png'),
    'Emirates'           => asset('images/airlines/emirates.png'),
    'Qatar Airways'      => asset('images/airlines/qatar-airways.png'),
    'Turkish Airlines'   => asset('images/airlines/turkish-airlines.png'),
    'Cathay Pacific'     => asset('images/airlines/cathay-pasific.png'),
    'Thai Airways'       => asset('images/airlines/thai.png'),
    'Jetstar Asia'       => asset('images/airlines/jetstar-airways.png'),
];

$logoUrl = $airlineLogo[$flight['maskapai']] ?? null;
@endphp

<div class="w-12 h-12 rounded-xl overflow-hidden flex items-center justify-center bg-white border border-gray-100 mx-auto mb-1 shadow-sm">
   @if($logoUrl)
    <img src="{{ $logoUrl }}"
         alt="{{ $flight['maskapai'] }}"
         class="w-12 h-12 object-contain">
@endif
</div>
                        </div>

                        {{-- Flight Info --}}
                        <div class="flex-1 flex items-center gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-gray-800 leading-none">{{ $flight['berangkat'] }}</div>
                                <div class="text-xs text-gray-400 mt-1 font-medium">{{ $from_code ?? '' }}</div>
                            </div>
                            <div class="flex-1 text-center">
                                <div class="text-xs text-gray-400 mb-1.5">{{ $flight['durasi'] }}</div>
                                <div class="relative">
                                    <div class="border-t-2 border-gray-200"></div>
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-blue-400 rounded-full -mt-px"></div>
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-blue-600 rounded-full -mt-px"></div>
                                </div>
                                <div class="mt-1.5">
                                    <span class="text-xs bg-green-50 text-green-600 font-semibold px-2 py-0.5 rounded-full">Langsung</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-gray-800 leading-none">{{ $flight['tiba'] }}</div>
                                <div class="text-xs text-gray-400 mt-1 font-medium">{{ $to_code ?? '' }}</div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-2.5 py-1 rounded-full">{{ $flight['kelas'] }}</span>
                                <span class="text-xs bg-gray-50 text-gray-500 px-2.5 py-1 rounded-full">🧳 Bagasi 20kg</span>
                                <span class="text-xs bg-gray-50 text-gray-500 px-2.5 py-1 rounded-full">🍽️ Makan</span>
                            </div>
                        </div>

                        {{-- Price & CTA --}}
                        <div class="flex-shrink-0 text-right w-40">
                            <div class="text-xs text-gray-400 mb-0.5">{{ $passengers }} penumpang</div>
                            <div class="text-2xl font-extrabold text-blue-600 leading-none">{{ $flight['harga'] }}</div>
                            <div class="text-xs text-gray-400 mb-3">per orang</div>
                            <form action="/booking" method="GET">
                                <input type="hidden" name="maskapai" value="{{ $flight['maskapai'] }}">
                                <input type="hidden" name="kode" value="{{ $flight['kode'] }}">
                                <input type="hidden" name="berangkat" value="{{ $flight['berangkat'] }}">
                                <input type="hidden" name="tiba" value="{{ $flight['tiba'] }}">
                                <input type="hidden" name="durasi" value="{{ $flight['durasi'] }}">
                                <input type="hidden" name="harga" value="{{ $flight['harga'] }}">
                                <input type="hidden" name="kelas" value="{{ $flight['kelas'] }}">
                                <input type="hidden" name="from" value="{{ $from }}">
                                <input type="hidden" name="to" value="{{ $to }}">
                                <input type="hidden" name="date" value="{{ $date }}">
                                <input type="hidden" name="passengers" value="{{ $passengers }}">
                                <input type="hidden" name="from_code" value="{{ $from_code ?? '' }}">
                                <input type="hidden" name="to_code" value="{{ $to_code ?? '' }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                                    Pilih →
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Toggle --}}
                    <div class="border-t border-gray-50 px-5 py-2.5 flex items-center justify-between bg-gray-50/50">
                        <div class="flex gap-4 text-xs text-gray-400">
                            <span>✈ {{ $flight['maskapai'] }}</span>
                            <span>·</span>
                            <span>{{ $date }}</span>
                            <span>·</span>
                            <span>Kelas {{ $flight['kelas'] }}</span>
                        </div>
                        <button class="text-xs text-blue-600 hover:underline font-medium">
                            Lihat detail penerbangan ↓
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- No results --}}
            <div id="no-results" class="text-center py-16">
                <div class="text-4xl mb-3">✈️</div>
                <div class="font-bold text-gray-700 text-lg mb-1">Tidak ada penerbangan</div>
                <div class="text-sm text-gray-400">Coba ubah filter untuk melihat lebih banyak hasil</div>
                <button onclick="resetFilters()" class="mt-4 text-sm text-blue-600 font-semibold hover:underline">Reset semua filter</button>
            </div>
        </div>
    </div>

<script>
    // ─── State ───────────────────────────────────────────────
    let activeTimeSlots = []; // kosong = semua waktu ditampilkan

    // ─── Time slot toggle ────────────────────────────────────
    function toggleTime(el) {
        el.classList.toggle('selected');
        const range = el.dataset.range;
        if (activeTimeSlots.includes(range)) {
            activeTimeSlots = activeTimeSlots.filter(r => r !== range);
        } else {
            activeTimeSlots.push(range);
        }
        applyFilters();
    }

    // ─── Main filter function ─────────────────────────────────
    function applyFilters() {
        // Kumpulkan maskapai yang dicentang
        const checkedAirlines = [...document.querySelectorAll('.filter-airline:checked')]
            .map(cb => cb.value);

        // Kumpulkan stop yang dicentang
        const checkedStops = [...document.querySelectorAll('.filter-stop:checked')]
            .map(cb => cb.value);

        // Bagasi
        const checkedBaggage = [...document.querySelectorAll('.filter-baggage:checked')]
            .map(cb => cb.value);

        const cards = document.querySelectorAll('.flight-card');
        let visible = 0;

        cards.forEach(card => {
            const maskapai = card.dataset.maskapai;
            const stop     = card.dataset.stop;     // "langsung" / "1transit" / "2transit"
            const jam      = parseInt(card.dataset.jam);

            // Cek maskapai
            const airlineOk = checkedAirlines.includes(maskapai);

            // Cek stop (kalau tidak ada yg dicentang = tampilkan semua)
            const stopOk = checkedStops.length === 0 || checkedStops.includes(stop);

            // Cek waktu (kalau tidak ada slot dipilih = tampilkan semua)
            let timeOk = true;
            if (activeTimeSlots.length > 0) {
                timeOk = activeTimeSlots.some(range => {
                    const [start, end] = range.split('-').map(Number);
                    return jam >= start && jam < end;
                });
            }

            // Bagasi: kalau tidak ada yg dicentang = tampilkan semua
            // (semua flight di sini "termasuk bagasi", jadi filter exclude akan hide semua)
            let baggageOk = true;
            if (checkedBaggage.length > 0) {
                baggageOk = checkedBaggage.includes('include');
            }

            const show = airlineOk && stopOk && timeOk && baggageOk;
            card.classList.toggle('hidden-flight', !show);
            if (show) visible++;
        });

        // Update count
        document.getElementById('result-count').textContent = visible + ' penerbangan';

        // Tampilkan pesan kosong kalau 0
        document.getElementById('no-results').style.display = visible === 0 ? 'block' : 'none';
    }

    // ─── Reset ────────────────────────────────────────────────
    function resetFilters() {
        document.querySelectorAll('.filter-airline').forEach(cb => cb.checked = true);
        document.querySelectorAll('.filter-stop').forEach((cb, i) => cb.checked = i === 0);
        document.querySelectorAll('.filter-baggage').forEach(cb => cb.checked = false);
        document.querySelectorAll('.time-slot').forEach(el => el.classList.remove('selected'));
        activeTimeSlots = [];
        applyFilters();
    }

    // ─── Sort ─────────────────────────────────────────────────
    function sortFlights(mode) {
        const list = document.getElementById('flight-list');
        const cards = [...list.querySelectorAll('.flight-card')];

        cards.sort((a, b) => {
            if (mode === 'cheap') return parseInt(a.dataset.harga) - parseInt(b.dataset.harga);
            if (mode === 'fast')  return a.dataset.durasi.localeCompare(b.dataset.durasi);
            return parseInt(a.dataset.harga) - parseInt(b.dataset.harga); // best = termurah
        });

        cards.forEach(card => list.appendChild(card));
    }
</script>

</body>
</html>