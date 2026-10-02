<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Check-in Online - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .input-field:focus { border-color: #1d4ed8; outline: none; box-shadow: 0 0 0 3px rgba(29,78,216,0.1); }
    </style>
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">
    @include('partials.sidebar', ['activePage' => 'check-in'])

    <main class="ml-[230px] flex-1">
        <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30">
            <h1 class="text-[16px] font-extrabold text-gray-900">Check-in Online</h1>
            <p class="text-[11.5px] text-gray-400 mt-0.5">Check-in 24 jam sebelum keberangkatan</p>
        </div>

        <div class="p-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-lg">

               @if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-xl px-4 py-3 mb-4">
    {{ session('success') }}
</div>
@endif

                <div class="text-center mb-6">
                    <div class="text-5xl mb-3">✅</div>
                    <h2 class="font-bold text-gray-900 text-lg mb-1">Check-in Online</h2>
                    <p class="text-gray-400 text-sm">Masukkan kode booking untuk memulai check-in online</p>
                </div>

                 <form method="POST" action="{{ route('checkin.process') }}">
                    @csrf
                    <input type="text" name="booking_code" placeholder="Kode booking (contoh: SKY-A1B2C3D4)"
                        value="{{ old('booking_code') }}"
                        class="input-field w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 mb-3" required>
                    <input type="text" name="passenger_name" placeholder="Nama depan sesuai tiket"
                        value="{{ old('passenger_name') }}"
                        class="input-field w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 mb-4" required>
                    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition text-sm">
                        Mulai Check-in →
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>