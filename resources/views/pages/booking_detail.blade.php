<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Segoe UI', system-ui, sans-serif; }</style>
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">

    @include('partials.sidebar', ['activePage' => 'bookings'])

    <main class="ml-[230px] flex-1">
        <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30 flex items-center gap-3">
            <a href="/bookings" class="text-gray-400 hover:text-gray-700 text-sm">← Kembali</a>
            <div>
                <h1 class="text-[16px] font-extrabold text-gray-900">Detail Pesanan</h1>
                <p class="text-[11.5px] text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
            </div>
        </div>

        <div class="p-8 max-w-3xl">

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-5">
                <div class="bg-[#0f172a] text-white px-6 py-5 flex items-center justify-between">
                    <div>
                        <div class="text-blue-300 text-xs font-medium mb-1">Kode Booking</div>
                        <div class="font-extrabold text-xl tracking-widest">{{ $booking->booking_code }}</div>
                    </div>
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full
                        {{ $booking->payment_status === 'paid' ? 'bg-green-500 text-white' :
                            ($booking->payment_status === 'cancelled' ? 'bg-red-500 text-white' : 'bg-yellow-400 text-yellow-900') }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
                <h2 class="font-bold text-gray-900 mb-4">Detail Penerbangan</h2>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs text-gray-400">{{ date('d M Y', strtotime($booking->tanggal)) }} · {{ $booking->maskapai }} {{ $booking->kode_penerbangan }}</span>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $booking->kelas }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center flex-1">
                            <div class="text-2xl font-extrabold text-gray-800">{{ $booking->berangkat }}</div>
                            <div class="text-xs font-bold text-gray-500 mt-1">{{ $booking->from_code }}</div>
                            <div class="text-xs text-gray-400">{{ $booking->from }}</div>
                        </div>
                        <div class="flex-1 text-center">
                            <div class="text-xs text-gray-400 mb-1">{{ $booking->durasi }}</div>
                            <div class="flex items-center gap-1">
                                <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                                <div class="flex-1 h-px bg-blue-200"></div>
                                <span class="text-blue-500 text-xs">✈</span>
                                <div class="flex-1 h-px bg-blue-200"></div>
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            </div>
                            <span class="text-xs bg-green-50 text-green-600 font-bold px-2 py-0.5 rounded-full mt-1 inline-block">Langsung</span>
                        </div>
                        <div class="text-center flex-1">
                            <div class="text-2xl font-extrabold text-gray-800">{{ $booking->tiba }}</div>
                            <div class="text-xs font-bold text-gray-500 mt-1">{{ $booking->to_code }}</div>
                            <div class="text-xs text-gray-400">{{ $booking->to }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
                <h2 class="font-bold text-gray-900 mb-4">Informasi Kontak & Penumpang</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Nama Penumpang</div>
                        <div class="font-bold text-gray-800 text-sm">{{ $booking->contact_name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Jumlah Penumpang</div>
                        <div class="font-bold text-gray-800 text-sm">{{ $booking->jumlah_penumpang }} Orang</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Email</div>
                        <div class="font-bold text-gray-800 text-sm">{{ $booking->contact_email ?: '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Nomor HP</div>
                        <div class="font-bold text-gray-800 text-sm">{{ $booking->contact_phone ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-5">
                <h2 class="font-bold text-gray-900 mb-4">Rincian Pembayaran</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Harga tiket</span>
                        <span class="font-medium text-gray-700">Rp {{ number_format($booking->harga_tiket, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jumlah penumpang</span>
                        <span class="font-medium text-gray-700">x {{ $booking->jumlah_penumpang }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pajak & biaya</span>
                        <span class="font-medium text-gray-700">Rp {{ number_format($booking->pajak, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Biaya layanan</span>