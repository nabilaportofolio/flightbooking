<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .input-field {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            background: #fafafa;
        }
        .input-field:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        .photo-panel {
            position: relative;
            overflow: hidden;
            border-radius: 0 24px 24px 0;
        }
        .photo-panel img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .photo-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,22,40,0.8) 0%, rgba(10,22,40,0.2) 55%, transparent 100%);
        }
    </style>
</head>
<body class="bg-[#f0f4f9] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex w-full" style="max-width: 900px; min-height: 620px;">

        {{-- ═══ LEFT: FORM ═══ --}}
        <div class="flex flex-col justify-center px-12 py-10 w-full" style="flex: 1.1;">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5 mb-7">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-md">
                    <span class="text-white text-base">✈</span>
                </div>
                <span class="font-extrabold text-gray-900 text-[17px] tracking-tight">SkyBook</span>
            </a>

            <h1 class="text-[26px] font-extrabold text-gray-900 leading-tight mb-1">
                Buat akun gratis<br>sekarang! 🚀
            </h1>
            <p class="text-[13.5px] text-gray-400 font-medium mb-6">
                Cepat, mudah, dan langsung bisa pesan tiket
            </p>

            {{-- Error --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-[13px] rounded-xl px-4 py-3 mb-4 font-medium">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="/register" class="flex flex-col gap-3.5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Nama kamu" class="input-field" required>
                </div>

                {{-- Email & HP (2 col) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="email@contoh.com" class="input-field" required>
                    </div>
                    <div>
                        <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Nomor HP</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx" class="input-field" required>
                    </div>
                </div>

                {{-- Password & Konfirmasi (2 col) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Password</label>
                        <input type="password" name="password"
                            placeholder="Min. 8 karakter" class="input-field" required>
                    </div>
                    <div>
                        <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Konfirmasi</label>
                        <input type="password" name="password_confirmation"
                            placeholder="Ulangi password" class="input-field" required>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 rounded-xl transition text-[14px] shadow-lg shadow-blue-100 mt-1 active:scale-[0.99]">
                    Daftar Sekarang ✨
                </button>
            </form>

            <p class="text-center text-[13px] text-gray-400 mt-5">
                Sudah punya akun?
                <a href="/login" class="text-blue-600 font-bold hover:text-blue-800">Masuk di sini</a>
            </p>
        </div>

        {{-- ═══ RIGHT: PHOTO ═══ --}}
        <div class="photo-panel hidden md:block" style="flex: 0.9;">
            <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&q=85" alt="Travel">
            <div class="photo-overlay"></div>
            <div class="absolute bottom-8 left-8 right-8 text-white z-10">
                <div class="text-[22px] font-extrabold leading-tight mb-2">
                    Jutaan destinasi<br>menunggumu 🌍
                </div>
                <p class="text-white/70 text-[13px] font-medium">
                    Gratis selamanya · Tanpa biaya tersembunyi
                </p>
            </div>
        </div>

    </div>

</body>
</html>