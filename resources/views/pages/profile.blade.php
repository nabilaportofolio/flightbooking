<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Penumpang - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">

@include('partials.sidebar', ['activePage' => 'profile'])

<main class="ml-[230px] flex-1">
    <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30">
        <h1 class="text-[16px] font-extrabold text-gray-900">Profil Penumpang</h1>
        <p class="text-[11.5px] text-gray-400 mt-0.5">Kelola data akun dan informasi perjalanan kamu</p>
    </div>

    <div class="p-8">
        @auth
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-3xl p-7 text-white mb-6 shadow-xl shadow-blue-200">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center text-3xl font-black">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold">{{ Auth::user()->name }}</h2>
                    <p class="text-blue-100 text-sm">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 bg-white/20 px-3 py-1 rounded-full text-xs font-bold">
                        ✈ SkyBook Member
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-5 border border-gray-100">
                <p class="text-xs text-gray-400 font-bold">Total Booking</p>
                <h3 class="text-3xl font-black text-blue-700 mt-1">12</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100">
                <p class="text-xs text-gray-400 font-bold">Upcoming Flight</p>
                <h3 class="text-3xl font-black text-green-600 mt-1">2</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100">
                <p class="text-xs text-gray-400 font-bold">Checked-in</p>
                <h3 class="text-3xl font-black text-amber-500 mt-1">4</h3>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100">
                <p class="text-xs text-gray-400 font-bold">Member Since</p>
                <h3 class="text-xl font-black text-gray-800 mt-2">{{ Auth::user()->created_at->format('Y') }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 bg-white rounded-3xl border border-gray-100 p-7">
                <h3 class="font-extrabold text-gray-900 mb-5">Data Penumpang</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->name }}"
                               class="w-full mt-2 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}"
                               class="w-full mt-2 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Nomor HP</label>
                        <input type="text" value="{{ Auth::user()->phone ?? '' }}" placeholder="08xxxxxxxxxx"
                               class="w-full mt-2 border border-gray-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Kewarganegaraan</label>
                        <select class="w-full mt-2 border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white">
                            <option>Indonesia</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                </div>

                <button class="mt-6 bg-blue-700 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl text-sm">
                    Simpan Perubahan
                </button>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 p-7">
                <h3 class="font-extrabold text-gray-900 mb-4">Ringkasan Akun</h3>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        <span class="font-bold text-green-600">Aktif</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Tipe Member</span>
                        <span class="font-bold text-blue-700">Regular</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Verifikasi</span>
                        <span class="font-bold text-gray-800">Email</span>
                    </div>
                </div>

                <div class="mt-6 bg-blue-50 rounded-2xl p-4">
                    <div class="text-2xl mb-2">🎫</div>
                    <h4 class="font-bold text-gray-900 text-sm">Booking lebih cepat</h4>
                    <p class="text-xs text-gray-400 mt-1">
                        Data penumpang akan membantu proses pemesanan tiket lebih praktis.
                    </p>
                </div>
            </div>
        </div>
        @endauth
    </div>
</main>

</body>
</html>