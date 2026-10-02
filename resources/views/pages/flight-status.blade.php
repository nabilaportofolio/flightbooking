<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Penerbangan - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f0f4f9] flex min-h-screen">

@include('partials.sidebar', ['activePage' => 'flight-status'])

<main class="ml-[230px] flex-1">
    <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30">
        <h1 class="text-[16px] font-extrabold text-gray-900">Status Penerbangan</h1>
        <p class="text-[11.5px] text-gray-400 mt-0.5">Cek status penerbangan berdasarkan kode booking atau nomor penerbangan</p>
    </div>

    <div class="p-8">

        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6 max-w-xl">
            <h3 class="font-bold text-gray-900 mb-4">Cek Status Penerbangan</h3>

            <form method="GET" action="{{ route('flight.status') }}" class="flex gap-3">
                <input type="text" name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="Masukkan kode booking / nomor penerbangan"
                    class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800">

                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-600 text-white font-semibold px-5 py-3 rounded-xl transition text-sm">
                    Cek →
                </button>
            </form>
        </div>

        @if(($keyword ?? null) && $booking)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-xl mb-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center font-black text-blue-700 text-sm">
                    ✈
                </div>

                <div>
                    <div class="font-bold text-gray-900">{{ $booking->maskapai }}</div>
                    <div class="text-xs text-gray-400">
                        {{ $booking->kode_penerbangan }} · {{ $booking->kelas }}
                    </div>
                </div>

                <div class="ml-auto">
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-green-100 text-green-700">
                        On Time
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-4 mb-5">
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $booking->berangkat }}</div>
                    <div class="text-xs text-gray-400 font-semibold">{{ $booking->from_code }}</div>
                </div>

                <div class="flex-1 text-center">
                    <div class="text-xs text-gray-400 mb-1.5">{{ $booking->durasi }}</div>
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                        <div class="flex-1 h-px bg-blue-200"></div>
                        <span class="text-blue-500 text-xs">✈</span>
                        <div class="flex-1 h-px bg-blue-200"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                    </div>
                    <div class="mt-1.5">
                        <span class="text-xs bg-green-50 text-green-600 font-bold px-2 py-0.5 rounded-full">
                            Langsung
                        </span>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-2xl font-extrabold text-gray-900">{{ $booking->tiba }}</div>
                    <div class="text-xs text-gray-400 font-semibold">{{ $booking->to_code }}</div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 bg-gray-50 rounded-xl p-4">
                <div class="text-center">
                    <div class="text-xs text-gray-400 mb-0.5">Kode Booking</div>
                    <div class="font-bold text-gray-700 text-sm">{{ $booking->booking_code }}</div>
                </div>

                <div class="text-center border-x border-gray-200">
                    <div class="text-xs text-gray-400 mb-0.5">Tanggal</div>
                    <div class="font-bold text-gray-700 text-sm">{{ $booking->tanggal }}</div>
                </div>

                <div class="text-center">
                    <div class="text-xs text-gray-400 mb-0.5">Penumpang</div>
                    <div class="font-bold text-gray-700 text-sm">{{ $booking->jumlah_penumpang }}</div>
                </div>
            </div>
        </div>

        @elseif($keyword ?? null)
        <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 max-w-xl mb-6">
            Data penerbangan tidak ditemukan.
        </div>
        @endif

        <div class="max-w-xl">
            <h3 class="font-bold text-gray-900 mb-3 text-sm">Riwayat Penerbangan Kamu</h3>

            <div class="space-y-2">
                @forelse($popularFlights as $flight)
                <a href="{{ route('flight.status', ['keyword' => $flight->kode_penerbangan]) }}"
                   class="bg-white rounded-xl border border-gray-100 px-4 py-3 flex items-center gap-4 hover:border-blue-200 transition">
                    <div class="font-bold text-gray-700 text-sm w-20">{{ $flight->kode_penerbangan }}</div>
                    <div class="flex-1 text-xs text-gray-400">{{ $flight->maskapai }}</div>
                    <div class="text-xs font-semibold text-gray-700">{{ $flight->from_code }} → {{ $flight->to_code }}</div>
                    <div class="text-xs text-gray-400">{{ $flight->berangkat }} - {{ $flight->tiba }}</div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                        On Time
                    </span>
                </a>
                @empty
                <div class="bg-white rounded-xl border border-gray-100 px-4 py-5 text-sm text-gray-400">
                    Belum ada riwayat penerbangan.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</main>

</body>
</html>