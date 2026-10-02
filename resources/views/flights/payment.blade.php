<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .input-field:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29,78,216,0.1); outline: none; }
        .payment-option { transition: all 0.2s; cursor: pointer; }
        .payment-option:hover { border-color: #3b82f6; background: #f0f7ff; }
        .payment-option.selected { border-color: #1d4ed8 !important; background: #eff6ff; }
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
            <a href="#" class="hover:text-white">Explore</a>
            <a href="#" class="hover:text-white">Flights</a>
            <a href="#" class="hover:text-white">Bookings</a>
        </div>
        <div class="flex gap-2">
            @auth
            <span class="text-sm text-slate-300 font-medium">{{ Auth::user()->name }}</span>
            @else
            <a href="/login" class="text-sm text-slate-300 hover:text-white px-3 py-1.5">Login</a>
            <a href="/register" class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded-lg">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- STEP INDICATOR --}}
    <div class="bg-white border-b border-slate-100 px-8 py-4">
        <div class="max-w-4xl mx-auto flex items-center">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-blue-700 text-white flex items-center justify-center text-xs font-bold">✓</div>
                <span class="text-sm font-semibold text-blue-700">Pilih Penerbangan</span>
            </div>
            <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-blue-700 text-white flex items-center justify-center text-xs font-bold">✓</div>
                <span class="text-sm font-semibold text-blue-700">Data Penumpang</span>
            </div>
            <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-blue-700 text-white flex items-center justify-center text-xs font-bold">3</div>
                <span class="text-sm font-bold text-blue-700">Pembayaran</span>
            </div>
        </div>
    </div>

    {{-- COUNTDOWN BANNER --}}
    <div class="bg-amber-50 border-b border-amber-200 px-8 py-2.5">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2 text-amber-700 text-sm">
                <span>⏱️</span>
                <span class="font-medium">Selesaikan pembayaran sebelum harga berubah</span>
            </div>
            <div class="font-extrabold text-amber-700 text-lg" id="countdown">14:59</div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8 flex gap-6">

        {{-- LEFT --}}
        <div class="flex-1 space-y-5">

            {{-- Flight Detail --}}
            <div class="card p-6">
                <h2 class="font-bold text-slate-800 text-base mb-4">Detail Penerbangan</h2>
                <div class="bg-slate-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs text-slate-400 font-medium">Pergi · {{ $date }}</div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $flight['kelas'] }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-800 to-blue-600 rounded-xl flex items-center justify-center text-white font-black text-xs flex-shrink-0">
                            {{ substr($flight['maskapai'], 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-slate-400 mb-2">{{ $flight['maskapai'] }} · {{ $flight['kode'] }}</div>
                            <div class="flex items-center gap-3">
                                <div>
                                    <div class="text-2xl font-extrabold text-slate-800 leading-none">{{ $flight['berangkat'] }}</div>
                                    <div class="text-xs text-slate-500 mt-1 font-semibold">{{ $from_code ?? '' }}</div>
                                </div>
                                <div class="flex-1 text-center">
                                    <div class="text-xs text-slate-400 mb-1.5">{{ $flight['durasi'] }}</div>
                                    <div class="flex items-center gap-1">
                                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                                        <div class="flex-1 h-px bg-blue-200"></div>
                                        <span class="text-blue-500 text-xs">✈</span>
                                        <div class="flex-1 h-px bg-blue-200"></div>
                                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                    </div>
                                    <div class="mt-1.5">
                                        <span class="text-xs bg-green-50 text-green-600 font-bold px-2 py-0.5 rounded-full">Langsung</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-extrabold text-slate-800 leading-none">{{ $flight['tiba'] }}</div>
                                    <div class="text-xs text-slate-500 mt-1 font-semibold">{{ $to_code ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mt-4 pt-4 border-t border-slate-200">
                        <div class="text-center">
                            <div class="text-xs text-slate-400 mb-0.5">Kode</div>
                            <div class="text-sm font-bold text-slate-700">{{ $flight['kode'] }}</div>
                        </div>
                        <div class="text-center border-x border-slate-100">
                            <div class="text-xs text-slate-400 mb-0.5">Bagasi</div>
                            <div class="text-sm font-bold text-slate-700">20 Kg</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-slate-400 mb-0.5">Penumpang</div>
                            <div class="text-sm font-bold text-slate-700">{{ $passengers }} Orang</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Form --}}
            <form method="POST" action="/payment/process">
                @csrf
                <input type="hidden" name="payment_method" id="selectedMethod" value="transfer_bank">
                <input type="hidden" name="maskapai" value="{{ $flight['maskapai'] }}">
                <input type="hidden" name="kode" value="{{ $flight['kode'] }}">
                <input type="hidden" name="berangkat" value="{{ $flight['berangkat'] }}">
                <input type="hidden" name="tiba" value="{{ $flight['tiba'] }}">
                <input type="hidden" name="durasi" value="{{ $flight['durasi'] }}">
                <input type="hidden" name="harga" value="{{ $flight['harga'] }}">
                <input type="hidden" name="kelas" value="{{ $flight['kelas'] }}">
                <input type="hidden" name="from" value="{{ $from }}">
                <input type="hidden" name="to" value="{{ $to }}">
                <input type="hidden" name="from_code" value="{{ $from_code ?? '' }}">
                <input type="hidden" name="to_code" value="{{ $to_code ?? '' }}">
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="passengers" value="{{ $passengers }}">
                <input type="hidden" name="passengers" value="{{ $passengers }}">
<input type="hidden" name="contact_name" value="{{ request('contact_name') }}">
<input type="hidden" name="contact_phone" value="{{ request('contact_phone') }}">
<input type="hidden" name="contact_email" value="{{ request('contact_email') }}">
@for($i = 1; $i <= $passengers; $i++)
<input type="hidden" name="pax_{{ $i }}_firstname" value="{{ request('pax_' . $i . '_firstname') }}">
<input type="hidden" name="pax_{{ $i }}_lastname" value="{{ request('pax_' . $i . '_lastname') }}">
@endfor

                <div class="card p-6">
                    <h2 class="font-bold text-slate-800 text-base mb-1">Pilih Metode Pembayaran</h2>
                    <p class="text-xs text-slate-400 mb-5">Pilih salah satu metode pembayaran yang tersedia.</p>

                    <div class="space-y-3">
                        <div class="payment-option selected border-2 border-blue-700 rounded-2xl p-4 flex items-center gap-4"
                             onclick="selectPayment(this, 'transfer_bank')">
                            <div class="w-5 h-5 rounded-full border-2 border-blue-700 flex items-center justify-center flex-shrink-0">
                                <div class="w-2.5 h-2.5 bg-blue-700 rounded-full" id="dot_transfer_bank"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-sm font-bold text-slate-800">Transfer Bank</span>
                                    <span class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">Manual</span>
                                </div>
                                <div class="text-xs text-slate-400">BCA, Mandiri, BNI, BRI · Transfer ke rekening SkyBook, lalu simpan bukti.</div>
                            </div>
                            <div class="flex gap-1.5 flex-shrink-0">
                                @foreach(['BCA', 'BRI', 'BNI'] as $bank)
                                <div class="bg-blue-700 text-white text-[10px] font-black px-2 py-0.5 rounded">{{ $bank }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="payment-option border-2 border-slate-200 rounded-2xl p-4 flex items-center gap-4"
                             onclick="selectPayment(this, 'qris')">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center flex-shrink-0">
                                <div class="w-2.5 h-2.5 bg-transparent rounded-full" id="dot_qris"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-sm font-bold text-slate-800">QRIS</span>
                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-medium">Instant</span>
                                </div>
                                <div class="text-xs text-slate-400">Scan QR dengan GoPay, OVO, DANA, ShopeePay, atau m-banking.</div>
                            </div>
                            <span class="text-2xl flex-shrink-0">📱</span>
                        </div>

                        <div class="payment-option border-2 border-slate-200 rounded-2xl p-4 flex items-center gap-4"
                             onclick="selectPayment(this, 'virtual_account')">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center flex-shrink-0">
                                <div class="w-2.5 h-2.5 bg-transparent rounded-full" id="dot_virtual_account"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-sm font-bold text-slate-800">Virtual Account</span>
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-medium">Auto Check</span>
                                </div>
                                <div class="text-xs text-slate-400">Nomor VA dibuat otomatis · Bayar lewat ATM atau mobile banking.</div>
                            </div>
                            <span class="text-2xl flex-shrink-0">🏧</span>
                        </div>

                        <div class="payment-option border-2 border-slate-200 rounded-2xl p-4 flex items-center gap-4"
                             onclick="selectPayment(this, 'kartu_kredit')">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center flex-shrink-0">
                                <div class="w-2.5 h-2.5 bg-transparent rounded-full" id="dot_kartu_kredit"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-sm font-bold text-slate-800">Kartu Kredit / Debit</span>
                                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full font-medium">Secure</span>
                                </div>
                                <div class="text-xs text-slate-400">Visa, Mastercard · Pembayaran terenkripsi SSL 256-bit.</div>
                            </div>
                            <div class="flex gap-1.5 flex-shrink-0">
                                <div class="bg-blue-600 text-white text-[10px] font-black px-2 py-0.5 rounded">VISA</div>
                                <div class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded">MC</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">
                        <span>🔒</span>
                        <span>Pembayaran kamu aman. Data transaksi tidak akan dibagikan kepada pihak lain.</span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-5 bg-blue-700 hover:bg-blue-600 text-white font-extrabold py-4 rounded-2xl text-base transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                    🔒 Bayar Sekarang
                </button>
            </form>
        </div>

        {{-- RIGHT --}}
        <div class="w-72 flex-shrink-0">
            <div class="card p-5 sticky top-28 space-y-4">
                <h3 class="font-bold text-slate-800">Ringkasan Pesanan</h3>

                <div class="bg-slate-50 rounded-xl p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">Pergi</span>
                    </div>
                    <div class="font-bold text-slate-800 text-sm">{{ $from }} → {{ $to }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $date }} · {{ $flight['berangkat'] }} - {{ $flight['tiba'] }}</div>
                    <div class="text-xs text-slate-500 mt-1 font-medium">{{ $flight['maskapai'] }} · {{ $flight['kode'] }}</div>
                </div>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Harga tiket</span>
                        <span class="font-medium text-slate-700">{{ $flight['harga'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Penumpang</span>
                        <span class="font-medium text-slate-700">x {{ $passengers }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Pajak & biaya</span>
                        <span class="font-medium text-slate-700">Rp 50.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Biaya layanan</span>
                        <span class="font-medium text-slate-700">Rp 25.000</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3">
    @php
        $harga_num = (int) preg_replace('/[^0-9]/', '', $flight['harga']);
        $total_num = ($harga_num * $passengers) + 50000 + 25000;
        $total_display = 'Rp ' . number_format($total_num, 0, ',', '.');
    @endphp
    
    <div class="flex justify-between text-sm mb-1">
        <span class="text-slate-500">Subtotal ({{ $passengers }}x tiket)</span>
        <span class="text-slate-700">Rp {{ number_format($harga_num * $passengers, 0, ',', '.') }}</span>
    </div>
    <div class="flex justify-between font-bold text-slate-800 text-base pt-2 border-t border-slate-100 mt-2">
        <span>Total</span>
        <span class="text-blue-700">{{ $total_display }}</span>
    </div>
</div>

                <div class="bg-red-50 rounded-xl p-3 border border-red-100">
                    <div class="text-xs font-bold text-red-600 mb-1">⏰ Batas Pembayaran</div>
                    <div class="text-xs text-red-500">Selesaikan sebelum:</div>
                    <div class="text-sm font-extrabold text-red-600 mt-0.5">
                        {{ now()->addMinutes(15)->format('d M Y, H:i') }} WIB
                    </div>
                </div>

                <p class="text-xs text-slate-400 text-center leading-relaxed">
                    Setelah pembayaran berhasil, e-tiket dikirim ke email yang sudah diisi.
                </p>
            </div>
        </div>
    </div>

    <script>
    let minutes = 14, seconds = 59;
    const countdown = document.getElementById('countdown');
    setInterval(() => {
        if (seconds === 0) {
            if (minutes === 0) return;
            minutes--; seconds = 59;
        } else { seconds--; }
        countdown.textContent = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
    }, 1000);

    function selectPayment(el, value) {
        // Reset semua
        document.querySelectorAll('.payment-option').forEach(o => {
            o.classList.remove('selected');
            o.style.borderColor = '#e2e8f0';
            o.style.background = '';
            const dot = o.querySelector('[id^="dot_"]');
            if (dot) { dot.style.background = 'transparent'; dot.parentElement.style.borderColor = '#cbd5e1'; }
        });
        // Aktifkan yang dipilih
        el.classList.add('selected');
        el.style.borderColor = '#1d4ed8';
        el.style.background = '#eff6ff';
        const dot = document.getElementById('dot_' + value);
        if (dot) { dot.style.background = '#1d4ed8'; dot.parentElement.style.borderColor = '#1d4ed8'; }
        document.getElementById('selectedMethod').value = value;
    }
    </script>

</body>
</html>