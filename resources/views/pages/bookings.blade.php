<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Segoe UI', system-ui, sans-serif; }</style>
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">

    @include('partials.sidebar', ['activePage' => 'bookings'])

    <main class="ml-[230px] flex-1">
        <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30">
            <h1 class="text-[16px] font-extrabold text-gray-900">Kelola Pesanan</h1>
            <p class="text-[11.5px] text-gray-400 mt-0.5">Lihat dan kelola semua pesanan tiketmu</p>
        </div>

        <div class="p-8">
            @if($bookings->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                    <div class="text-6xl mb-4"></div>
                    <h2 class="text-xl font-bold text-slate-700 mb-2">Belum ada pesanan</h2>
                    <p class="text-slate-400 mb-6 text-sm">Kamu belum pernah memesan tiket melalui SkyBook.</p>
                    <a href="/" class="bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-600 transition inline-block text-sm">
                        Cari Penerbangan →
                    </a>
                </div>
            @else
                <div class="flex flex-col gap-4">
                    @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

                        {{-- Header --}}
                        <div class="bg-[#0f172a] text-white px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="font-extrabold text-base">
                                    {{ $booking->from }} → {{ $booking->to }}
                                </div>
                                <div class="text-blue-300 text-xs mt-0.5 font-mono">
                                    {{ $booking->booking_code }}
                                </div>
                            </div>
                            <span class="text-xs font-bold px-3 py-1.5 rounded-full
                                {{ $booking->payment_status === 'paid' ? 'bg-green-500 text-white' : 
                                   ($booking->payment_status === 'cancelled' ? 'bg-red-500 text-white' : 'bg-yellow-400 text-yellow-900') }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-4 gap-6 mb-5">
                                <div>
                                    <div class="text-xs text-gray-400 mb-1">Penumpang</div>
                                    <div class="font-bold text-gray-800 text-sm">{{ $booking->contact_name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 mb-1">Maskapai</div>
                                    <div class="font-bold text-gray-800 text-sm">{{ $booking->maskapai }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 mb-1">Jadwal</div>
                                    <div class="font-bold text-gray-800 text-sm">
                                        {{ date('d M Y', strtotime($booking->tanggal)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 mb-1">Total</div>
                                    <div class="font-bold text-blue-600 text-sm">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4 flex gap-3">
                                @if($booking->payment_status === 'paid')
                                <a href="{{ route('flights.ticket', $booking->booking_code) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition">
                                    Lihat E-Tiket
                                </a>
                                @else
                                <span class="bg-gray-100 text-gray-400 text-sm font-bold px-5 py-2.5 rounded-xl cursor-not-allowed">
                                    E-Tiket (Belum Bayar)
                                </span>
                                @endif
                                <a href="{{ route('booking.detail', $booking->booking_code) }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold px-5 py-2.5 rounded-xl transition inline-block">
                                Detail Pesanan
                            </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</body>
</html>