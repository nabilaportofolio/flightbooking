<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .input-field {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
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
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 11px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            gap: 8px;
        }
        .social-btn:hover { background: #f9fafb; border-color: #d1d5db; }
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
            background: linear-gradient(to top, rgba(10,22,40,0.75) 0%, rgba(10,22,40,0.2) 60%, transparent 100%);
        }
    </style>
</head>
<body class="bg-[#f0f4f9] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex w-full" style="max-width: 900px; min-height: 580px;">

        {{-- ═══ LEFT: FORM ═══ --}}
        <div class="flex flex-col justify-center px-12 py-10 w-full" style="flex: 1.1;">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5 mb-8">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-md">
                    <span class="text-white text-base">✈</span>
                </div>
                <span class="font-extrabold text-gray-900 text-[17px] tracking-tight">SkyBook</span>
            </a>

            <h1 class="text-[26px] font-extrabold text-gray-900 leading-tight mb-1">
                Selamat datang<br>kembali! 👋
            </h1>
            <p class="text-[13.5px] text-gray-400 font-medium mb-7">
                Masuk untuk melanjutkan pemesanan tiketmu
            </p>

            {{-- Error --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-[13px] rounded-xl px-4 py-3 mb-5 font-medium">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="/login" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="text-[12px] font-bold text-gray-500 mb-1.5 block uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@contoh.com" class="input-field" required>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-[12px] font-bold text-gray-500 uppercase tracking-wide">Password</label>
                        <a href="#" class="text-[12px] text-blue-500 font-semibold hover:text-blue-700">Lupa password?</a>
                    </div>
                    <input type="password" name="password" placeholder="••••••••" class="input-field" required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 rounded-xl transition text-[14px] shadow-lg shadow-blue-100 mt-1 active:scale-[0.99]">
                    Masuk →
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-[12px] text-gray-400 font-medium">atau</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            {{-- Social --}}
            <div class="flex gap-2">
                <button class="social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Google
                </button>
                <button class="social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    Apple
                </button>
                <button class="social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </button>
            </div>

            <p class="text-center text-[13px] text-gray-400 mt-6">
                Belum punya akun?
                <a href="/register" class="text-blue-600 font-bold hover:text-blue-800">Daftar sekarang</a>
            </p>
        </div>

        {{-- ═══ RIGHT: PHOTO ═══ --}}
        <div class="photo-panel hidden md:block" style="flex: 0.9;">
            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&q=85" alt="Travel">
            <div class="photo-overlay"></div>
            <div class="absolute bottom-8 left-8 right-8 text-white z-10">
                <div class="text-[22px] font-extrabold leading-tight mb-2">
                    Saatnya merencanakan<br>perjalanan impianmu ✈
                </div>
                <p class="text-white/70 text-[13px] font-medium">
                    500+ maskapai · Harga terbaik · Booking dalam 3 menit
                </p>
            </div>
        </div>

    </div>

</body>
</html>