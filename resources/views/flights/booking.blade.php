<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penumpang - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .step-done { background: #1d4ed8; color: white; }
        .step-active { background: #1d4ed8; color: white; }
        .step-inactive { background: #e5e7eb; color: #9ca3af; }
        .input-field { transition: all 0.2s; }
        .input-field:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29,78,216,0.1); outline: none; }
        .card { background: white; border: 1px solid #f1f5f9; border-radius: 16px; }
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
            <a href="#" class="hover:text-white transition">Explore</a>
            <a href="#" class="hover:text-white transition">Flights</a>
            <a href="#" class="hover:text-white transition">Bookings</a>
        </div>
        <div class="flex gap-2">
            @auth
            <span class="text-sm text-slate-300 font-medium">{{ Auth::user()->name }}</span>
            @else
            <a href="/login" class="text-sm text-slate-300 hover:text-white px-3 py-1.5">Login</a>
            <a href="/register" class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded-lg hover:bg-blue-500">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- STEP INDICATOR --}}
    <div class="bg-white border-b border-slate-100 px-8 py-4">
        <div class="max-w-4xl mx-auto flex items-center gap-0">
            <div class="flex items-center gap-2">
                <div class="step-done w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">✓</div>
                <span class="text-sm font-semibold text-blue-700">Pilih Penerbangan</span>
            </div>
            <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="step-active w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">2</div>
                <span class="text-sm font-bold text-blue-700">Data Penumpang</span>
            </div>
            <div class="flex-1 h-0.5 bg-slate-200 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="step-inactive w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold">3</div>
                <span class="text-sm font-medium text-slate-400">Pembayaran</span>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8 flex gap-6">

        {{-- LEFT COLUMN --}}
        <div class="flex-1">

            <form id="bookingForm" action="{{ route('flights.payment') }}" method="GET" class="space-y-5">
                <input type="hidden" name="from" value="{{ $from }}">
                <input type="hidden" name="to" value="{{ $to }}">
                <input type="hidden" name="from_code" value="{{ $from_code ?? '' }}">
                <input type="hidden" name="to_code" value="{{ $to_code ?? '' }}">
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="passengers" value="{{ $passengers }}">
                <input type="hidden" name="maskapai" value="{{ $flight['maskapai'] }}">
                <input type="hidden" name="kode" value="{{ $flight['kode'] }}">
                <input type="hidden" name="berangkat" value="{{ $flight['berangkat'] }}">
                <input type="hidden" name="tiba" value="{{ $flight['tiba'] }}">
                <input type="hidden" name="durasi" value="{{ $flight['durasi'] }}">
                <input type="hidden" name="harga" value="{{ $flight['harga'] }}">
                <input type="hidden" name="kelas" value="{{ $flight['kelas'] }}">

                {{-- Contact Details --}}
                <div class="card p-6">
                    <h2 class="font-bold text-slate-800 text-base mb-1">Informasi Kontak</h2>
                    <p class="text-xs text-slate-400 mb-5">E-tiket dan informasi perjalanan akan dikirim ke kontak ini.</p>

                    <div class="flex gap-3 mb-5">
                        @foreach(['Mr.' => 'mr', 'Mrs.' => 'mrs', 'Ms.' => 'ms'] as $label => $val)
                        <label class="flex items-center gap-2 border border-slate-200 rounded-xl px-4 py-2.5 cursor-pointer hover:border-blue-400 transition flex-1 justify-center">
                            <input type="radio" name="title" value="{{ $val }}" {{ $val == 'mr' ? 'checked' : '' }} class="accent-blue-600">
                            <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1.5 block uppercase tracking-wide">Nama kontak</label>
                            <input type="text" name="contact_name" placeholder="Contoh: Aya Mardi Kalea"
                                class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1.5 block uppercase tracking-wide">Nomor HP</label>
                            <div class="flex">
                                <div class="border border-slate-200 border-r-0 rounded-l-xl px-3 py-3 bg-slate-50 text-sm text-slate-500 font-medium">+62</div>
                                <input type="tel" name="contact_phone" placeholder="8xxxxxxxxxx"
                                    class="input-field flex-1 border border-slate-200 rounded-r-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="text-xs font-semibold text-slate-500 mb-1.5 block uppercase tracking-wide">Email</label>
                            <input type="email" name="contact_email" placeholder="email@contoh.com"
                                class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                        </div>
                    </div>
                </div>

                {{-- Passenger Details --}}
                @for($i = 1; $i <= $passengers; $i++)
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Data Penumpang</h2>
                            <p class="text-xs text-slate-400">Isi sesuai identitas resmi penumpang.</p>
                        </div>
                        <div class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-100">
                            Penumpang {{ $i }}
                        </div>
                    </div>

                    {{-- Personal Info --}}
                    <div class="mb-5">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <div class="w-px h-3 bg-blue-400"></div> Informasi Pribadi
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama depan *</label>
                                <input type="text" name="pax_{{ $i }}_firstname" placeholder="Nama depan"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nama belakang *</label>
                                <input type="text" name="pax_{{ $i }}_lastname" placeholder="Nama belakang"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Jenis kelamin *</label>
                                <select name="pax_{{ $i }}_gender"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white cursor-pointer" required>
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Tanggal lahir *</label>
                                <input type="date" name="pax_{{ $i }}_dob"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white" required>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Kewarganegaraan *</label>
                                <select name="pax_{{ $i }}_nationality"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white cursor-pointer" required>
                                    <option value="">Pilih kewarganegaraan</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="SG">Singapura</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="AU">Australia</option>
                                    <option value="JP">Jepang</option>
                                    <option value="GB">Inggris</option>
                                    <option value="US">Amerika Serikat</option>
                                    <option value="OTHER">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Identity Info --}}
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <div class="w-px h-3 bg-blue-400"></div> Informasi Identitas
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Jenis identitas *</label>
                                <select name="pax_{{ $i }}_id_type"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white cursor-pointer" required>
                                    <option value="">Pilih jenis identitas</option>
                                    <option value="ktp">KTP (WNI)</option>
                                    <option value="passport">Paspor</option>
                                    <option value="sim">SIM</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Nomor identitas *</label>
                                <input type="text" name="pax_{{ $i }}_id_number" placeholder="Nomor KTP / Paspor"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300" required>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Negara penerbit</label>
                                <select name="pax_{{ $i }}_id_country"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white cursor-pointer">
                                    <option value="">Pilih negara</option>
                                    <option value="ID" selected>Indonesia</option>
                                    <option value="SG">Singapura</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="AU">Australia</option>
                                    <option value="JP">Jepang</option>
                                    <option value="GB">Inggris</option>
                                    <option value="US">Amerika Serikat</option>
                                    <option value="OTHER">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1.5 block">Masa berlaku identitas</label>
                                <input type="date" name="pax_{{ $i }}_id_expiry"
                                    class="input-field w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 bg-white">
                            </div>
                        </div>
                    </div>
                </div>
                @endfor

                {{-- Add-ons --}}
                <div class="card p-6">
                    <h2 class="font-bold text-slate-800 text-base mb-1">Layanan Tambahan</h2>
                    <p class="text-xs text-slate-400 mb-4">Tingkatkan pengalaman perjalananmu.</p>
                    <div class="space-y-3">
                        @foreach([
                            ['🧳', 'Extra Baggage', 'Tambah bagasi hingga 30kg', 'Rp 150.000'],
                            ['🍽️', 'In-flight Meals', 'Pilih menu makanan perjalananmu', 'Rp 75.000'],
                            ['💺', 'Seat Selection', 'Pilih kursi dekat jendela atau lorong', 'Rp 50.000'],
                        ] as [$icon, $name, $desc, $price])
                        <label class="flex items-center justify-between border border-slate-100 rounded-xl p-4 cursor-pointer hover:border-blue-300 hover:bg-blue-50/30 transition group">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">{{ $icon }}</span>
                                <div>
                                    <div class="text-sm font-semibold text-slate-700">{{ $name }}</div>
                                    <div class="text-xs text-slate-400">{{ $desc }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-blue-600">{{ $price }}</span>
                                <input type="checkbox" name="addon_{{ strtolower(str_replace(' ', '_', $name)) }}"
                                    class="accent-blue-600 w-4 h-4">
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Agreement --}}
                <div class="flex items-start gap-3 px-1">
                    <input type="checkbox" id="agree" required class="accent-blue-600 w-4 h-4 mt-0.5 flex-shrink-0">
                    <label for="agree" class="text-xs text-slate-500 leading-relaxed cursor-pointer">
                        Saya memastikan data penumpang sudah sesuai identitas resmi dan menyetujui
                        <a href="#" class="text-blue-600 hover:underline font-medium">syarat & ketentuan pemesanan</a> SkyBook.
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-600 active:bg-blue-800 text-white font-bold py-4 rounded-2xl text-base transition shadow-lg shadow-blue-200">
                    Lanjut ke Pembayaran →
                </button>
            </form>
        </div>

        {{-- RIGHT COLUMN — Order Summary --}}
        <div class="w-72 flex-shrink-0">
            <div class="card p-5 sticky top-24">
                <h3 class="font-bold text-slate-800 mb-4">Ringkasan Penerbangan</h3>

                {{-- Route --}}
                <div class="bg-slate-50 rounded-xl p-4 mb-4">
                    <div class="text-xs text-slate-400 font-medium mb-3">Pergi</div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <div class="text-lg font-extrabold text-slate-800">{{ $flight['berangkat'] }}</div>
                            <div class="text-xs text-slate-500 font-medium">{{ $from_code ?? '' }}</div>
                        </div>
                        <div class="text-center px-3">
                            <div class="text-xs text-slate-400 mb-1">{{ $flight['durasi'] }}</div>
                            <div class="flex items-center gap-1">
                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                                <div class="w-12 h-px bg-blue-300"></div>
                                <span class="text-blue-500 text-xs">✈</span>
                                <div class="w-12 h-px bg-blue-300"></div>
                                <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                            </div>
                            <div class="text-[10px] text-green-600 font-semibold mt-1">Langsung</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-extrabold text-slate-800">{{ $flight['tiba'] }}</div>
                            <div class="text-xs text-slate-500 font-medium">{{ $to_code ?? '' }}</div>
                        </div>
                    </div>
                    <div class="border-t border-slate-100 pt-3 mt-3 space-y-1.5">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Maskapai</span>
                            <span class="font-semibold text-slate-700">{{ $flight['maskapai'] }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Nomor</span>
                            <span class="font-semibold text-slate-700">{{ $flight['kode'] }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-semibold text-slate-700">{{ $flight['kelas'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Price Breakdown --}}
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Harga tiket</span>
                        <span class="font-medium text-slate-700">{{ $flight['harga'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Penumpang</span>
                        <span class="font-medium text-slate-700">x {{ $passengers }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Pajak & biaya</span>
                        <span class="font-medium text-slate-700">Rp 50.000</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <div class="flex justify-between">
                        <span class="font-bold text-slate-800">Total</span>
                        <span class="font-extrabold text-blue-700 text-base">{{ $flight['harga'] }}</span>
                    </div>
                </div>

                <div class="mt-4 bg-blue-50 rounded-xl p-3 border border-blue-100">
                    <p class="text-xs text-blue-600 leading-relaxed">
                        🔒 Harga sudah diamankan. Lengkapi data penumpang untuk lanjut ke pembayaran.
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>