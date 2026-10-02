<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        .card { background: white; border: 1px solid #f1f5f9; border-radius: 16px; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-only { display: block !important; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-[#0f172a] px-8 py-4 flex items-center justify-between sticky top-0 z-50 no-print">
        <a href="/" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-black text-sm">✈</div>
            <span class="font-extrabold text-white text-lg tracking-tight">SkyBook</span>
        </a>
        <div class="flex items-center gap-6 text-sm text-slate-400">
            <a href="#" class="hover:text-white">Explore</a>
            <a href="#" class="hover:text-white">Flights</a>
            <a href="/bookings" class="hover:text-white">Bookings</a>
        </div>
        @auth
        <span class="text-sm text-slate-300 font-medium">{{ Auth::user()->name }}</span>
        @endauth
    </nav>

    {{-- STEP INDICATOR --}}
    <div class="bg-white border-b border-slate-100 px-8 py-4 no-print">
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
                <div class="w-7 h-7 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">✓</div>
                <span class="text-sm font-bold text-green-600">Selesai</span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- SUCCESS HEADER --}}
        <div class="card p-8 text-center mb-6 border-t-4 border-t-green-500">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">✅</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-slate-400 text-sm mb-5">Selesaikan pembayaran sebelum batas waktu agar tiket diterbitkan.</p>
            <div class="inline-flex items-center gap-3 bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl">
                <div>
                    <div class="text-xs text-slate-400 font-medium mb-0.5">Kode Booking</div>
                    <div class="font-extrabold text-blue-700 tracking-widest text-lg" id="bookingCode">{{ $booking_code }}</div>
                </div>
                <button onclick="copyText('{{ $booking_code }}')"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition">
                    📋 Salin
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">

            {{-- LEFT: Payment Instructions --}}
            <div class="col-span-2 space-y-5">

                {{-- Flight Summary --}}
                <div class="card p-5">
                    <h2 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs">✈</span>
                        Detail Penerbangan
                    </h2>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs text-slate-400">{{ $date }} · {{ $flight['maskapai'] }} {{ $flight['kode'] }}</span>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $flight['kelas'] }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-slate-800">{{ $flight['berangkat'] }}</div>
                                <div class="text-xs font-bold text-slate-500 mt-0.5">{{ $from_code }}</div>
                                <div class="text-xs text-slate-400">{{ $from }}</div>
                            </div>
                            <div class="flex-1 text-center">
                                <div class="text-xs text-slate-400 mb-1">{{ $flight['durasi'] }}</div>
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                                    <div class="flex-1 h-px bg-blue-200"></div>
                                    <span class="text-blue-500 text-xs">✈</span>
                                    <div class="flex-1 h-px bg-blue-200"></div>
                                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                </div>
                                <span class="text-xs bg-green-50 text-green-600 font-bold px-2 py-0.5 rounded-full mt-1 inline-block">Langsung</span>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-slate-800">{{ $flight['tiba'] }}</div>
                                <div class="text-xs font-bold text-slate-500 mt-0.5">{{ $to_code }}</div>
                                <div class="text-xs text-slate-400">{{ $to }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Method Instructions --}}
                @if($payment_method === 'virtual_account')
                <div class="card p-5">
                    <h2 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="text-xl">🏧</span> Instruksi Virtual Account
                    </h2>
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-5">
                        <div class="text-xs text-blue-500 font-bold uppercase tracking-wide mb-1">Nomor Virtual Account BCA</div>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-extrabold text-blue-800 tracking-widest">{{ $va_number }}</div>
                            <button onclick="copyText('{{ $va_number }}')"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                                📋 Salin
                            </button>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wide">Cara Pembayaran</div>
                        @foreach([
                            'Buka aplikasi m-banking atau ATM bank kamu',
                            'Pilih menu <strong>Transfer / Virtual Account</strong>',
                            'Masukkan nomor VA: <strong class="text-blue-700">' . $va_number . '</strong>',
                            'Pastikan nominal transfer: <strong class="text-blue-700">' . $total . '</strong>',
                            'Konfirmasi dan simpan bukti pembayaran',
                        ] as $i => $step)
                        <div class="flex gap-3 items-start">
                            <div class="w-6 h-6 bg-blue-700 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">{{ $i+1 }}</div>
                            <p class="text-sm text-slate-600 leading-relaxed">{!! $step !!}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                @elseif($payment_method === 'qris')
                <div class="card p-5">
                    <h2 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="text-xl">📱</span> Scan QRIS
                    </h2>
                    <div class="flex justify-center mb-5">
                        <div class="bg-white border-2 border-slate-200 rounded-2xl p-5 shadow-sm">
                            <svg viewBox="0 0 200 200" class="w-48 h-48" xmlns="http://www.w3.org/2000/svg">
                                <rect width="200" height="200" fill="white"/>
                                <rect x="10" y="10" width="60" height="60" rx="6" fill="#1e3a5f"/>
                                <rect x="17" y="17" width="46" height="46" rx="3" fill="white"/>
                                <rect x="24" y="24" width="32" height="32" rx="2" fill="#1e3a5f"/>
                                <rect x="130" y="10" width="60" height="60" rx="6" fill="#1e3a5f"/>
                                <rect x="137" y="17" width="46" height="46" rx="3" fill="white"/>
                                <rect x="144" y="24" width="32" height="32" rx="2" fill="#1e3a5f"/>
                                <rect x="10" y="130" width="60" height="60" rx="6" fill="#1e3a5f"/>
                                <rect x="17" y="137" width="46" height="46" rx="3" fill="white"/>
                                <rect x="24" y="144" width="32" height="32" rx="2" fill="#1e3a5f"/>
                                @php
                                $dots = [[85,15],[95,15],[105,15],[85,25],[105,25],[95,35],[85,45],[95,55],[105,45],[85,65],[95,65],[15,85],[35,85],[55,85],[75,85],[95,85],[115,85],[135,85],[155,85],[175,85],[15,95],[45,95],[75,95],[105,95],[135,95],[165,95],[25,105],[55,105],[85,105],[115,105],[145,105],[175,105],[35,115],[65,115],[95,115],[125,115],[155,115],[85,125],[115,125],[145,125],[175,125],[95,135],[125,135],[155,135],[85,145],[115,145],[165,145],[95,155],[135,155],[85,165],[105,165],[135,165],[165,165]];
                                @endphp
                                @foreach($dots as $d)
                                <rect x="{{ $d[0] }}" y="{{ $d[1] }}" width="8" height="8" fill="#1e3a5f"/>
                                @endforeach
                                <rect x="86" y="86" width="28" height="28" rx="5" fill="#1d4ed8"/>
                                <text x="100" y="105" text-anchor="middle" fill="white" font-size="12" font-weight="bold">S</text>
                            </svg>
                            <div class="text-center mt-3">
                                <div class="text-xs font-bold text-slate-600">SkyBook · QRIS</div>
                                <div class="text-xs text-slate-400">{{ $booking_code }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wide">Cara Scan</div>
                        @foreach([
                            'Buka GoPay, OVO, DANA, ShopeePay, atau m-banking',
                            'Pilih menu <strong>Scan QR / QRIS</strong>',
                            'Arahkan kamera ke QR code di atas',
                            'Konfirmasi pembayaran <strong class="text-blue-700">' . $total . '</strong>',
                        ] as $i => $step)
                        <div class="flex gap-3 items-start">
                            <div class="w-6 h-6 bg-blue-700 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">{{ $i+1 }}</div>
                            <p class="text-sm text-slate-600">{!! $step !!}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                @elseif($payment_method === 'transfer_bank')
                <div class="card p-5">
                    <h2 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="text-xl">🏦</span> Transfer Bank
                    </h2>
                    <div class="space-y-3 mb-5">
                        @foreach([
                            ['BCA', '1234567890', '#005BAA'],
                            ['Mandiri', '9876543210', '#003D6B'],
                            ['BNI', '1122334455', '#F26522'],
                            ['BRI', '5544332211', '#00529B'],
                        ] as [$bank, $number, $color])
                        <div class="border border-slate-100 rounded-xl p-4 flex items-center justify-between hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="text-white text-xs font-black px-3 py-1.5 rounded-lg min-w-[52px] text-center" style="background: {{ $color }}">{{ $bank }}</div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800 tracking-wider">{{ $number }}</div>
                                    <div class="text-xs text-slate-400">a.n. PT SkyBook Indonesia</div>
                                </div>
                            </div>
                            <button onclick="copyText('{{ $number }}')"
                                class="text-xs text-blue-600 hover:text-blue-800 font-semibold border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                                Salin
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex items-center gap-2">
                        <span>⚠️</span>
                        <span class="text-xs text-amber-700">Transfer tepat <strong>{{ $total }}</strong> — nominal berbeda akan memperlambat verifikasi.</span>
                    </div>
                </div>

                @else
                <div class="card p-5 text-center">
                    <div class="text-4xl mb-3">💳</div>
                    <h2 class="font-bold text-slate-800 mb-2">Kartu Kredit / Debit</h2>
                    <p class="text-sm text-slate-400 mb-4">Klik tombol di bawah untuk melanjutkan pembayaran kartu.</p>
                    <button class="bg-blue-700 text-white font-bold px-8 py-3 rounded-xl hover:bg-blue-600 transition">
                        Bayar dengan Kartu →
                    </button>
                </div>
                @endif

               {{-- Action Buttons --}}
<div class="flex gap-3 no-print">
    <a href="/" class="flex-1 border-2 border-slate-200 text-slate-600 font-semibold py-3 rounded-2xl text-center hover:border-blue-400 hover:text-blue-600 transition text-sm">
        ← Beranda
    </a>
    <a href="/ticket/{{ $booking_code }}?maskapai={{ urlencode($flight['maskapai']) }}&kode={{ $flight['kode'] }}&berangkat={{ $flight['berangkat'] }}&tiba={{ $flight['tiba'] }}&durasi={{ urlencode($flight['durasi']) }}&harga={{ urlencode($flight['harga']) }}&kelas={{ $flight['kelas'] }}&from={{ urlencode($from) }}&to={{ urlencode($to) }}&from_code={{ $from_code }}&to_code={{ $to_code }}&date={{ $date }}&passengers={{ $passengers }}&total={{ urlencode($total) }}"
       class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-2xl text-center transition text-sm">
        Saya Sudah Bayar → Lihat Tiket
    </a>
</div>
            {{-- RIGHT: Order Summary --}}
            <div class="col-span-1">
                <div class="card p-5 sticky top-24 space-y-4">

                    {{-- Countdown --}}
                    <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
                        <div class="text-xs font-bold text-red-500 uppercase tracking-wide mb-1">⏰ Batas Pembayaran</div>
                        <div class="text-3xl font-extrabold text-red-600 tabular-nums" id="countdown">14:59</div>
                        <div class="text-xs text-red-400 mt-1">{{ now()->addMinutes(15)->format('d M Y, H:i') }} WIB</div>
                    </div>

                    <h3 class="font-bold text-slate-800">Ringkasan Pesanan</h3>

                    <div class="bg-slate-50 rounded-xl p-3 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Rute</span>
                            <span class="font-semibold text-slate-700">{{ $from_code }} → {{ $to_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tanggal</span>
                            <span class="font-semibold text-slate-700">{{ $date }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Maskapai</span>
                            <span class="font-semibold text-slate-700">{{ $flight['maskapai'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Penumpang</span>
                            <span class="font-semibold text-slate-700">{{ $passengers }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-semibold text-slate-700">{{ $flight['kelas'] }}</span>
                        </div>
                    </div>

                    @php
                        $harga_num = (int) preg_replace('/[^0-9]/', '', $flight['harga']);
                        $subtotal = $harga_num * $passengers;
                    @endphp

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Harga tiket</span>
                            <span class="text-slate-700">Rp {{ number_format($harga_num, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Penumpang</span>
                            <span class="text-slate-700">x {{ $passengers }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Pajak & biaya</span>
                            <span class="text-slate-700">Rp 50.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Biaya layanan</span>
                            <span class="text-slate-700">Rp 25.000</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex justify-between">
                            <span class="font-bold text-slate-800">Total Bayar</span>
                            <span class="font-extrabold text-blue-700 text-lg">{{ $total }}</span>
                        </div>
                    </div>

                    <div class="text-xs text-slate-400 text-center">🔒 Pembayaran aman & terenkripsi SSL</div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Countdown
    let minutes = 14, seconds = 59;
    const countdown = document.getElementById('countdown');
    setInterval(() => {
        if (seconds === 0) {
            if (minutes === 0) return;
            minutes--; seconds = 59;
        } else { seconds--; }
        countdown.textContent = `${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
    }, 1000);

    // Copy text
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            const btns = document.querySelectorAll('button');
            btns.forEach(btn => {
                if (btn.textContent.includes('Salin') || btn.textContent.includes('📋')) {
                    const orig = btn.innerHTML;
                    btn.innerHTML = '✓ Tersalin!';
                    btn.style.color = '#16a34a';
                    setTimeout(() => { btn.innerHTML = orig; btn.style.color = ''; }, 2000);
                }
            });
        });
    }

    // Print ticket
    <a href="{{ route('flights.ticket', $booking_code) }}"
   class="...">
   🎫 Lihat & Cetak E-Tiket
</a>
    function printTicket() {
        window.print();
    }
    </script>
</body>
</html>