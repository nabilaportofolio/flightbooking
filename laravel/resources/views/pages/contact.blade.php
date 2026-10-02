<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hubungi Kami - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Segoe UI', system-ui, sans-serif; }</style>
</head>
<body class="bg-[#f0f4f9] flex min-h-screen">
    @include('partials.sidebar', ['activePage' => 'contact'])
    <main class="ml-[230px] flex-1">
        <div class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-30">
            <h1 class="text-[16px] font-extrabold text-gray-900">Hubungi Kami</h1>
            <p class="text-[11.5px] text-gray-400 mt-0.5">Tim kami siap membantu 24/7</p>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-3 gap-4 mb-8 max-w-3xl">
                @foreach([
                    ['💬', 'Live Chat', 'Respon dalam 2 menit', 'Mulai Chat →', 'blue'],
                    ['📧', 'Email', 'support@skybook.id', 'Kirim Email →', 'green'],
                    ['📞', 'Telepon', '+62 21 1234 5678', 'Hubungi →', 'purple'],
                ] as [$icon, $title, $desc, $btn, $color])
                <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-md transition">
                    <div class="text-3xl mb-3">{{ $icon }}</div>
                    <h3 class="font-bold text-gray-900 mb-1">{{ $title }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ $desc }}</p>
                    <button class="text-sm font-semibold text-blue-600 hover:underline">{{ $btn }}</button>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
                <h3 class="font-bold text-gray-900 mb-4">Kirim Pesan</h3>
                <div class="space-y-3">
                    <input type="text" placeholder="Nama lengkap" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-blue-400">
                    <input type="email" placeholder="Email" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-blue-400">
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-blue-400 bg-white text-gray-600">
                        <option>Pilih topik</option>
                        <option>Pembayaran</option>
                        <option>Perubahan tiket</option>
                        <option>Refund</option>
                        <option>Lainnya</option>
                    </select>
                    <textarea placeholder="Tuliskan pesanmu di sini..." rows="4"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-blue-400 resize-none"></textarea>
                    <button class="w-full bg-blue-700 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition text-sm">
                        Kirim Pesan →
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>