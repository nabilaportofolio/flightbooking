<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket {{ $booking_code }} - SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',system-ui,sans-serif; print-color-adjust:exact; -webkit-print-color-adjust:exact; }
        body { background:#f0f4f9; }

        /* Navbar */
        .navbar { background:#0f172a; padding:14px 32px; display:flex; align-items:center; justify-content:space-between; position:fixed; top:0; left:0; right:0; z-index:50; }
        .navbar-logo { display:flex; align-items:center; gap:10px; text-decoration:none; }
        .navbar-icon { width:34px; height:34px; background:#3b82f6; border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-weight:900; font-size:16px; }
        .navbar-name { font-weight:800; color:white; font-size:17px; }
        .navbar-btns { display:flex; gap:10px; }
        .btn-print { background:#2563eb; color:white; font-weight:700; padding:9px 20px; border-radius:12px; font-size:13px; border:none; cursor:pointer; }
        .btn-back { border:1.5px solid #475569; color:#cbd5e1; font-weight:600; padding:9px 20px; border-radius:12px; font-size:13px; text-decoration:none; display:inline-block; }

        .page { padding:100px 24px 40px; }
        .badge { text-align:center; margin-bottom:28px; }
        .badge span { background:#dcfce7; color:#15803d; font-weight:700; font-size:13px; padding:10px 20px; border-radius:999px; display:inline-block; }

        /* ═══ BOARDING PASS ═══ */
        .bp-outer { max-width:860px; margin:0 auto; border-radius:18px; overflow:hidden; box-shadow:0 16px 60px rgba(0,0,0,0.18); display:flex; flex-direction:column; }

        /* Top black bar */
        .bp-topbar { background:#111; color:white; text-align:center; font-size:14px; font-weight:900; letter-spacing:0.2em; text-transform:uppercase; padding:11px 0; }

        /* Main body = flex row */
        .bp-body { display:flex; min-height:360px; }

        /* ── LEFT WHITE PANEL ── */
        .bp-left { flex:1; background:white; padding:30px 36px; position:relative; overflow:hidden; }

        /* World map watermark */
        .bp-left::before {
            content:'';
            position:absolute; top:10%; left:15%; width:70%; height:80%;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 500 320'%3E%3Cellipse cx='250' cy='160' rx='240' ry='150' fill='none' stroke='%23b0bec5' stroke-width='5'/%3E%3Cellipse cx='250' cy='160' rx='160' ry='150' fill='none' stroke='%23b0bec5' stroke-width='3'/%3E%3Cellipse cx='250' cy='160' rx='80' ry='150' fill='none' stroke='%23b0bec5' stroke-width='3'/%3E%3Cline x1='10' y1='160' x2='490' y2='160' stroke='%23b0bec5' stroke-width='2'/%3E%3Cline x1='250' y1='10' x2='250' y2='310' stroke='%23b0bec5' stroke-width='2'/%3E%3Cpath d='M10,90 Q125,70 250,88 Q375,106 490,78' fill='none' stroke='%23b0bec5' stroke-width='2'/%3E%3Cpath d='M10,230 Q125,210 250,228 Q375,246 490,218' fill='none' stroke='%23b0bec5' stroke-width='2'/%3E%3C/svg%3E");
            background-size:contain; background-repeat:no-repeat; background-position:center;
            opacity:0.15; pointer-events:none;
        }

        /* Airline header */
        .bp-airline-row { display:flex; align-items:center; gap:8px; margin-bottom:20px; position:relative; z-index:1; }
        .bp-airline-name { font-size:16px; font-weight:900; letter-spacing:0.08em; text-transform:uppercase; color:#111; }

        /* IATA route */
        .bp-route { display:flex; align-items:flex-start; gap:0; margin-bottom:22px; position:relative; z-index:1; }
        .bp-iata { font-size:68px; font-weight:900; color:#111; line-height:1; letter-spacing:-3px; }
        .bp-arrow { font-size:32px; font-weight:900; color:#111; margin:0 14px; padding-top:14px; }
        .bp-city-sub { font-size:11px; color:#666; text-transform:uppercase; letter-spacing:0.1em; margin-top:5px; }

        /* Info grid */
        .bp-info { display:grid; grid-template-columns:repeat(4,1fr); gap:18px 20px; margin-bottom:22px; position:relative; z-index:1; }
        .bp-lbl { font-size:10px; color:#888; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:3px; }
        .bp-val { font-size:15px; font-weight:800; color:#111; }
        .bp-val.lg { font-size:26px; font-weight:900; }
        .bp-val.xl { font-size:44px; font-weight:900; line-height:1; }

        /* Barcode row */
        .bp-bottom { display:flex; align-items:flex-end; gap:16px; position:relative; z-index:1; }
        .bp-qr { border:2.5px solid #111; padding:5px; width:76px; height:76px; flex-shrink:0; }
        .bp-barcode { display:flex; align-items:flex-end; gap:1.5px; height:56px; flex:1; }
        .bp-barcode span { display:inline-block; width:2.5px; background:#111; border-radius:1px; }
        .bp-barcode-num { font-size:9px; color:#888; font-family:monospace; letter-spacing:0.1em; margin-top:5px; }

        /* ── RIGHT DARK STUB ── */
        .bp-right {
            width:210px; flex-shrink:0;
            background:#0f1f3d;
            padding:28px 22px;
            display:flex; flex-direction:column; gap:0;
            position:relative;
            border-left:2px dashed #334155;
        }
        /* Tear holes */
        .bp-right::before { content:''; position:absolute; top:-13px; left:-13px; width:26px; height:26px; background:#f0f4f9; border-radius:50%; }
        .bp-right::after  { content:''; position:absolute; bottom:-13px; left:-13px; width:26px; height:26px; background:#f0f4f9; border-radius:50%; }

        .stub-header { font-size:10px; color:#64748b; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:4px; }
        .stub-brand { font-size:16px; font-weight:900; color:white; margin-bottom:20px; }
        .stub-row { margin-bottom:14px; }
        .stub-lbl { font-size:9px; color:#64748b; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:3px; }
        .stub-val { font-size:13px; font-weight:800; color:white; }
        .stub-val.xl { font-size:22px; font-weight:900; }
        .stub-2col { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px; }
        .stub-divider { border-top:1px solid #1e3a5f; margin:14px 0; }

        /* Stub barcode */
        .stub-barcode-wrap { margin-top:auto; }
        .stub-barcode { display:flex; align-items:flex-end; gap:1px; height:80px; margin-bottom:6px; }
        .stub-barcode span { display:inline-block; width:2.5px; background:white; border-radius:1px; opacity:0.8; }
        .stub-code { font-size:8px; color:#475569; font-family:monospace; letter-spacing:0.08em; }

        /* Print button */
        .print-btn-wrap { text-align:center; margin-top:28px; }
        .print-btn { background:#1d4ed8; color:white; font-weight:700; padding:14px 40px; border-radius:16px; font-size:15px; border:none; cursor:pointer; box-shadow:0 8px 24px rgba(37,99,235,0.3); }
        .print-hint { font-size:11px; color:#94a3b8; margin-top:10px; }

        @media print {
            .no-print { display:none !important; }
            body { background:white !important; }
            .page { padding:0 !important; }
            .badge { display:none; }
            .bp-outer { box-shadow:none !important; max-width:100% !important; border-radius:0; }
            .bp-right::before, .bp-right::after { background:white; }
            @page { size:landscape; margin:6mm; }
        }
    </style>
</head>
<body>

    <nav class="navbar no-print">
        <a href="/" class="navbar-logo">
            <div class="navbar-icon">✈</div>
            <span class="navbar-name">SkyBook</span>
        </a>
        <div class="navbar-btns">
            <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
            <a href="/" class="btn-back">← Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="page">
        <div class="badge no-print">
            <span>✅ Pembayaran Dikonfirmasi · E-Tiket Siap Dicetak</span>
        </div>

        <div class="bp-outer">

            {{-- Top bar --}}
            <div class="bp-topbar">✈ &nbsp; Boarding Pass &nbsp; ✈</div>

            <div class="bp-body">

                {{-- ── LEFT WHITE ── --}}
                <div class="bp-left">

                    <div class="bp-airline-row">
                        <span style="font-size:20px;">✈</span>
                        <span class="bp-airline-name">SkyBook Airlines</span>
                        <span style="font-size:20px;">✈</span>
                    </div>

                    <div class="bp-route">
                        <div>
                            <div class="bp-iata">{{ strtoupper($from_code) }}</div>
                            <div class="bp-city-sub">{{ $from }}</div>
                        </div>
                        <div class="bp-arrow">→</div>
                        <div>
                            <div class="bp-iata">{{ strtoupper($to_code) }}</div>
                            <div class="bp-city-sub">{{ $to }}</div>
                        </div>
                    </div>

                    <div class="bp-info">
                        <div>
                            <div class="bp-lbl">Name</div>
                            <div class="bp-val">{{ $passenger_name }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Date</div>
                            <div class="bp-val">{{ date('d M Y', strtotime($date)) }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Flight</div>
                            <div class="bp-val">{{ $flight['kode'] }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Class</div>
                            <div class="bp-val">{{ $flight['kelas'] }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Origin</div>
                            <div class="bp-val">{{ strtoupper($from_code) }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Destination</div>
                            <div class="bp-val">{{ strtoupper($to_code) }}</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Departure Gate</div>
                            <div class="bp-val lg">G12</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Bag</div>
                            <div class="bp-val lg">02</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Boarding Time</div>
                            <div class="bp-val lg">@php echo date('H:i', strtotime($flight['berangkat'] . ' -30 minutes')); @endphp</div>
                        </div>
                        <div>
                            <div class="bp-lbl">Departure</div>
                            <div class="bp-val lg">{{ $flight['berangkat'] }}</div>
                        </div>
                        <div style="grid-column:span 2;">
                            <div class="bp-lbl">Seat</div>
                            <div class="bp-val xl">14A</div>
                        </div>
                    </div>

                    {{-- Barcode row --}}
                    <div class="bp-bottom">
                        {{-- QR --}}
                        <div class="bp-qr">
                            @php $qr=[1,1,1,0,1,1,1,1,0,0,0,0,0,1,1,0,1,0,1,0,1,1,0,1,0,1,0,1,1,0,1,0,1,0,1,1,1,1,0,0,0,1,0,0,0,0,1,1,0,0,1,1,1,1,0,0,1,0,1,0,1,1,0,1,0,1,0,1,1,0,1,0,1,0,1,1,0,0,0,0,0,1,1,1,1,0,1,1,1,0,1,0,0,1,0,1,1,0,1]; @endphp
                            <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:1px;width:100%;height:100%;">
                                @foreach($qr as $c)<div style="background:{{ $c ? '#111' : 'white' }};border-radius:1px;"></div>@endforeach
                            </div>
                        </div>
                        {{-- Linear barcode --}}
                        <div style="flex:1;">
                            <div class="bp-barcode">
                                @php $bh=[54,30,46,20,56,34,48,22,54,28,44,18,58,32,46,24,54,26,42,52,20,48,36,54,22,44,30,58,18,50,28,46,34,54,20,48,26,44,32,52,24,56,30,44,20,54,28,46,36,56]; @endphp
                                @foreach($bh as $px)<span style="height:{{$px}}px"></span>@endforeach
                            </div>
                            <div class="bp-barcode-num">{{ $booking_code }}-{{ strtoupper($from_code) }}{{ strtoupper($to_code) }}</div>
                        </div>
                    </div>

                </div>

                {{-- ── RIGHT DARK STUB ── --}}
                <div class="bp-right">

                    <div class="stub-header">Boarding Pass</div>
                    <div class="stub-brand">SkyBook</div>

                    <div class="stub-row">
                        <div class="stub-lbl">Nama</div>
                        <div class="stub-val">{{ $passenger_name }}</div>
                    </div>

                    <div class="stub-2col">
                        <div>
                            <div class="stub-lbl">Tanggal</div>
                            <div class="stub-val">{{ date('d M', strtotime($date)) }}</div>
                        </div>
                        <div>
                            <div class="stub-lbl">Flight</div>
                            <div class="stub-val">{{ $flight['kode'] }}</div>
                        </div>
                    </div>

                    <div class="stub-row">
                        <div class="stub-lbl">Origin</div>
                        <div class="stub-val">{{ strtoupper($from_code) }}</div>
                    </div>

                    <div class="stub-row">
                        <div class="stub-lbl">Destination</div>
                        <div class="stub-val">{{ strtoupper($to_code) }}</div>
                    </div>

                    <div class="stub-2col">
                        <div>
                            <div class="stub-lbl">Kursi</div>
                            <div class="stub-val xl">14A</div>
                        </div>
                        <div>
                            <div class="stub-lbl">Bagasi</div>
                            <div class="stub-val xl">20Kg</div>
                        </div>
                    </div>

                    <div class="stub-row">
                        <div class="stub-lbl">Kelas</div>
                        <div class="stub-val">{{ $flight['kelas'] }}</div>
                    </div>

                    <div class="stub-divider"></div>

                    <div class="stub-barcode-wrap">
                        <div class="stub-barcode">
                            @php $sv=[70,42,62,26,76,40,58,22,72,36,56,18,78,44,62,26,72,36,54,68,20,60,34,72,18,64,28,76,16,68,24,62,32,74,18,66,20,60,28,70]; @endphp
                            @foreach($sv as $px)<span style="height:{{$px}}px"></span>@endforeach
                        </div>
                        <div class="stub-code">{{ $booking_code }}</div>
                    </div>

                </div>

            </div>{{-- bp-body --}}
        </div>{{-- bp-outer --}}

        <div class="print-btn-wrap no-print">
            <button onclick="window.print()" class="print-btn">🖨️ Cetak E-Tiket / Simpan PDF</button>
            <div class="print-hint">Tunjukkan e-tiket ini saat check-in di bandara</div>
        </div>
    </div>

</body>
</html>