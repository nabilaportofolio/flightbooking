<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Flight;

class FlightController extends Controller
{
    /* =========================================================
     *  GENERATOR PENERBANGAN — jarak asli, harga & durasi proporsional
     * ========================================================= */

    /**
     * Koordinat (lat, lng) tiap bandara — dipakai untuk hitung jarak asli.
     * Nilai perkiraan, cukup akurat untuk estimasi durasi & harga.
     */
    private function airportCoordinates(): array
    {
        return [
            // Indonesia (domestik)
            'CGK' => [-6.1256, 106.6559], 'HLP' => [-6.2665, 106.8909], 'DPS' => [-8.7482, 115.1672],
            'SUB' => [-7.3798, 112.7869], 'YOG' => [-7.9026, 110.0570], 'MES' => [3.6422, 98.8853],
            'UPG' => [-5.0616, 119.5541], 'BPN' => [-1.2683, 116.8938], 'PLM' => [-2.8983, 104.6998],
            'SOC' => [-7.5162, 110.7570], 'SRG' => [-6.9714, 110.3742], 'BDO' => [-6.9007, 107.5764],
            'LOP' => [-8.7576, 116.2764],
            // Asia Tenggara
            'SIN' => [1.3644, 103.9915], 'KUL' => [2.7456, 101.7099], 'BKK' => [13.6900, 100.7501],
            'DMK' => [13.9126, 100.6068], 'MNL' => [14.5086, 121.0198], 'SGN' => [10.8188, 106.6520],
            'HAN' => [21.2212, 105.8072],
            // Asia Timur
            'HKG' => [22.3080, 113.9185], 'HND' => [35.5494, 139.7798], 'NRT' => [35.7720, 140.3929],
            'KIX' => [34.4347, 135.2441], 'ICN' => [37.4602, 126.4407], 'PEK' => [40.0799, 116.6031],
            'PVG' => [31.1443, 121.8083], 'TPE' => [25.0797, 121.2342],
            // Timur Tengah
            'DXB' => [25.2532, 55.3657], 'AUH' => [24.4330, 54.6511], 'DOH' => [25.2731, 51.6081],
            'RUH' => [24.9576, 46.6988], 'JED' => [21.6796, 39.1565],
            // Eropa
            'LHR' => [51.4700, -0.4543], 'LGW' => [51.1537, -0.1821], 'EDI' => [55.9500, -3.3725],
            'MAN' => [53.3537, -2.2750], 'CDG' => [49.0097, 2.5479], 'AMS' => [52.3105, 4.7683],
            'FRA' => [50.0379, 8.5622], 'MUC' => [48.3538, 11.7861], 'MAD' => [40.4983, -3.5676],
            'FCO' => [41.8003, 12.2389], 'IST' => [41.2753, 28.7519],
            // Australia & NZ
            'SYD' => [-33.9399, 151.1753], 'MEL' => [-37.6690, 144.8410], 'BNE' => [-27.3842, 153.1175],
            'AKL' => [-37.0082, 174.7850],
            // Amerika
            'JFK' => [40.6413, -73.7781], 'LAX' => [33.9416, -118.4085], 'SFO' => [37.6213, -122.3790],
            'YYZ' => [43.6777, -79.6248],
            // Afrika
            'JNB' => [-26.1392, 28.2460], 'CAI' => [30.1219, 31.4056],
        ];
    }

    /** Daftar 13 bandara domestik Indonesia */
    private function domesticAirports(): array
    {
        return ['CGK', 'HLP', 'DPS', 'SUB', 'YOG', 'MES', 'UPG', 'BPN', 'PLM', 'SOC', 'SRG', 'BDO', 'LOP'];
    }

    /** Jarak great-circle (km) antar 2 bandara, pakai rumus haversine */
    private function distanceKm(string $a, string $b): float
    {
        $coords = $this->airportCoordinates();
        if (!isset($coords[$a]) || !isset($coords[$b])) {
            return 1500; // fallback kalau kode bandara tidak dikenal
        }

        [$lat1, $lon1] = $coords[$a];
        [$lat2, $lon2] = $coords[$b];

        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $x = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($x), sqrt(1 - $x));

        return $earthRadius * $c;
    }

    /** Pool maskapai per kategori rute. tier 'budget' = tarif lebih murah, 'full' = full-service */
    private function airlinePools(): array
    {
        return [
            'domestic' => [
                ['nama' => 'Garuda Indonesia', 'kode' => 'GA', 'tier' => 'full'],
                ['nama' => 'Batik Air',        'kode' => 'ID', 'tier' => 'full'],
                ['nama' => 'Sriwijaya Air',    'kode' => 'SJ', 'tier' => 'full'],
                ['nama' => 'Citilink',         'kode' => 'QG', 'tier' => 'budget'],
                ['nama' => 'Lion Air',         'kode' => 'JT', 'tier' => 'budget'],
                ['nama' => 'Super Air Jet',    'kode' => 'IU', 'tier' => 'budget'],
                ['nama' => 'Wings Air',        'kode' => 'IW', 'tier' => 'budget'],
                ['nama' => 'TransNusa',        'kode' => '8B', 'tier' => 'budget'],
            ],
            'regional' => [
                ['nama' => 'Singapore Airlines',  'kode' => 'SQ', 'tier' => 'full'],
                ['nama' => 'Malaysia Airlines',   'kode' => 'MH', 'tier' => 'full'],
                ['nama' => 'Thai Airways',        'kode' => 'TG', 'tier' => 'full'],
                ['nama' => 'Cathay Pacific',      'kode' => 'CX', 'tier' => 'full'],
                ['nama' => 'Korean Air',          'kode' => 'KE', 'tier' => 'full'],
                ['nama' => 'Vietnam Airlines',    'kode' => 'VN', 'tier' => 'full'],
                ['nama' => 'Philippine Airlines', 'kode' => 'PR', 'tier' => 'full'],
                ['nama' => 'AirAsia',             'kode' => 'AK', 'tier' => 'budget'],
                ['nama' => 'Scoot',               'kode' => 'TR', 'tier' => 'budget'],
                ['nama' => 'Jetstar Asia',        'kode' => '3K', 'tier' => 'budget'],
            ],
            'longhaul' => [
                ['nama' => 'Emirates',         'kode' => 'EK', 'tier' => 'full'],
                ['nama' => 'Qatar Airways',    'kode' => 'QR', 'tier' => 'full'],
                ['nama' => 'Turkish Airlines', 'kode' => 'TK', 'tier' => 'full'],
                ['nama' => 'Singapore Airlines','kode' => 'SQ', 'tier' => 'full'],
                ['nama' => 'Etihad Airways',   'kode' => 'EY', 'tier' => 'full'],
                ['nama' => 'KLM',              'kode' => 'KL', 'tier' => 'full'],
                ['nama' => 'Cathay Pacific',   'kode' => 'CX', 'tier' => 'full'],
                ['nama' => 'ANA',              'kode' => 'NH', 'tier' => 'full'],
            ],
        ];
    }

    /** Estimasi durasi (menit) & harga (IDR) satu penerbangan berdasar jarak & tier maskapai */
    private function estimateFlight(array $airline, float $distanceKm, string $seed): array
    {
        // Kecepatan jelajah efektif (termasuk taxi & climb) — makin jauh, makin cepat rata-ratanya
        $cruiseSpeed = $distanceKm > 3000 ? 850 : ($distanceKm > 800 ? 800 : 650);
        $overheadMinutes = $distanceKm > 3000 ? 55 : ($distanceKm > 800 ? 35 : 25);
        $durationMinutes = (int) round(($distanceKm / $cruiseSpeed) * 60 + $overheadMinutes);

        // Tarif per km makin murah untuk jarak jauh (skala ekonomi maskapai)
        $baseRatePerKm = $distanceKm > 3000 ? 1450 : ($distanceKm > 800 ? 2100 : 2800);
        $tierMultiplier = $airline['tier'] === 'budget' ? 0.72 : 1.0;
        $baseFare = $distanceKm > 3000 ? 1800000 : ($distanceKm > 800 ? 350000 : 120000);

        $price = $baseFare + ($distanceKm * $baseRatePerKm * $tierMultiplier);

        // Variasi kecil tapi konsisten (biar antar maskapai gak persis sama harganya)
        mt_srand(crc32($seed));
        $price *= (1 + mt_rand(-8, 8) / 100);

        $price = (int) (round($price / 5000) * 5000); // bulatkan ke kelipatan 5.000

        return [$durationMinutes, $price];
    }

    /** Generate daftar penerbangan untuk 1 rute — konsisten selama rute & tanggalnya sama */
    private function generateFlights(string $fromCode, string $toCode): array
    {
        $domestic = $this->domesticAirports();
        $isDomestic = in_array($fromCode, $domestic) && in_array($toCode, $domestic);
        $distance = $this->distanceKm($fromCode, $toCode);
        $pools = $this->airlinePools();

        if ($isDomestic) {
            $pool = $pools['domestic'];
        } elseif ($distance > 6000) {
            $pool = $pools['longhaul'];
        } else {
            $pool = $pools['regional'];
        }

        // Seed berdasarkan rute -> hasil stabil kalau dicari ulang, tapi beda tiap rute
        mt_srand(crc32($fromCode . '-' . $toCode));
        $jumlah = mt_rand(min(5, count($pool)), min(8, count($pool)));
        $pickedKeys = array_rand($pool, $jumlah);
        $pickedKeys = is_array($pickedKeys) ? $pickedKeys : [$pickedKeys];

        $flights = [];
        foreach ($pickedKeys as $i => $key) {
            $airline = $pool[$key];
            [$durationMinutes, $price] = $this->estimateFlight($airline, $distance, $airline['kode'] . $fromCode . $toCode);

            mt_srand(crc32($airline['kode'] . $fromCode . $toCode));
            $departHour = mt_rand(5, 22);
            $departMinute = [0, 15, 30, 45][mt_rand(0, 3)];

            $departTotal = $departHour * 60 + $departMinute;
            $arriveTotal = ($departTotal + $durationMinutes) % (24 * 60);
            $arriveHour = intdiv($arriveTotal, 60);
            $arriveMinute = $arriveTotal % 60;

            $fmtJam = fn($h, $m) => sprintf('%02d:%02d', $h, $m);
            $sisaMenit = $durationMinutes % 60;
            $durasiText = intdiv($durationMinutes, 60) . 'j' . ($sisaMenit > 0 ? ' ' . $sisaMenit . 'm' : '');

            $flights[] = [
                'maskapai'  => $airline['nama'],
                'kode'      => $airline['kode'] . '-' . mt_rand(100, 999),
                'berangkat' => $fmtJam($departHour, $departMinute),
                'tiba'      => $fmtJam($arriveHour, $arriveMinute),
                'durasi'    => $durasiText,
                'harga'     => 'Rp ' . number_format($price, 0, ',', '.'),
                'harga_num' => $price,
                'kelas'     => 'Economy',
            ];
        }

        usort($flights, fn($a, $b) => strcmp($a['berangkat'], $b['berangkat']));

        return $flights;
    }

    /* =========================================================
     *  ROUTES
     * ========================================================= */

    public function search(Request $request)
    {
        $from = $request->query('from', '');
        $to = $request->query('to', '');
        $fromCode = $request->query('from_code', 'CGK');
        $toCode = $request->query('to_code', 'DPS');
        $date = $request->date;
        $passengers = $request->passengers ?? 1;

        $flights = $this->generateFlights($fromCode, $toCode);

        return view('flights.search', compact('flights', 'from', 'to', 'fromCode', 'toCode', 'date', 'passengers'));
    }

    public function booking(Request $request)
    {
        $flight = [
            'maskapai' => $request->maskapai,
            'kode'     => $request->kode,
            'berangkat'=> $request->berangkat,
            'tiba'     => $request->tiba,
            'durasi'   => $request->durasi,
            'harga'    => $request->harga,
            'harga_num'=> (int) preg_replace('/[^0-9]/', '', $request->harga),
            'kelas'    => $request->kelas,
        ];

        $from       = $request->from;
        $to         = $request->to;
        $from_code  = $request->from_code;
        $to_code    = $request->to_code;
        $date       = $request->date;
        $passengers = $request->passengers ?? 1;

        return view('flights.booking', compact(
            'flight', 'from', 'to', 'from_code', 'to_code', 'date', 'passengers'
        ));
    }

    public function payment(Request $request)
    {
        $from = $request->from ?? 'Jakarta (CGK)';
        $to = $request->to ?? 'Bali (DPS)';

        preg_match('/\((.*?)\)/', $from, $fromMatch);
        preg_match('/\((.*?)\)/', $to, $toMatch);

        $from_code = $fromMatch[1] ?? ($request->from_code ?? 'CGK');
        $to_code = $toMatch[1] ?? ($request->to_code ?? 'DPS');

        $flight = [
            'maskapai'  => $request->maskapai ?? 'Garuda Indonesia',
            'kode'      => $request->kode ?? 'GA-401',
            'berangkat' => $request->berangkat ?? '06:00',
            'tiba'      => $request->tiba ?? '09:00',
            'durasi'    => $request->durasi ?? '3j',
            'harga'     => $request->harga ?? 'Rp 850.000',
            'harga_num' => (int) preg_replace('/[^0-9]/', '', $request->harga ?? '850000'),
            'kelas'     => $request->kelas ?? 'Economy',
        ];

        $date = $request->date ?? now()->toDateString();
        $passengers = $request->passengers ?? 1;

        return view('flights.payment', compact(
            'flight',
            'from',
            'to',
            'from_code',
            'to_code',
            'date',
            'passengers'
        ));
    }

    public function processPayment(Request $request)
    {
        $harga_num  = (int) preg_replace('/[^0-9]/', '', $request->harga ?? '0');
        $passengers = $request->passengers ?? 1;
        $pajak      = 50000;
        $layanan    = 25000;
        $total_num  = ($harga_num * $passengers) + $pajak + $layanan;
        $total      = 'Rp ' . number_format($total_num, 0, ',', '.');

        $booking_code = 'SKY-' . strtoupper(Str::random(8));

        $from = $request->from ?? '';
        $to = $request->to ?? '';

        preg_match('/\((.*?)\)/', $from, $fromMatch);
        preg_match('/\((.*?)\)/', $to, $toMatch);

        $from_code = $fromMatch[1] ?? ($request->from_code ?? '');
        $to_code = $toMatch[1] ?? ($request->to_code ?? '');

        $passengerName = trim(
            ($request->input('pax_1_firstname') ?? '') . ' ' .
            ($request->input('pax_1_lastname') ?? '')
        );

        if ($passengerName === '') {
            $passengerName = $request->input('contact_name')
                ?? auth()->user()->name
                ?? 'Penumpang SkyBook';
        }

        Booking::create([
            'booking_id'       => Str::uuid(),
            'user_id'          => auth()->id(),
            'booking_code'     => $booking_code,
            'maskapai'         => $request->maskapai ?? '',
            'kode_penerbangan' => $request->kode ?? '',
            'from'             => $from,
            'to'               => $to,
            'from_code'        => $from_code,
            'to_code'          => $to_code,
            'tanggal'          => $request->date ?? now()->toDateString(),
            'berangkat'        => $request->berangkat ?? '',
            'tiba'             => $request->tiba ?? '',
            'durasi'           => $request->durasi ?? '',
            'kelas'            => $request->kelas ?? '',
            'jumlah_penumpang' => $passengers,
            'harga_tiket'      => $harga_num,
            'pajak'            => $pajak,
            'biaya_layanan'    => $layanan,
            'total_harga'      => $total_num,
            'contact_name'     => $passengerName,
            'contact_phone'    => $request->contact_phone ?? '',
            'contact_email'    => $request->contact_email ?? '',
            'payment_status'   => 'pending',
            'payment_method'   => $request->payment_method ?? 'transfer_bank',
        ]);

        $flight = [
            'maskapai'  => $request->maskapai ?? '',
            'kode'      => $request->kode ?? '',
            'berangkat' => $request->berangkat ?? '',
            'tiba'      => $request->tiba ?? '',
            'durasi'    => $request->durasi ?? '',
            'harga'     => $request->harga ?? '',
            'kelas'     => $request->kelas ?? '',
        ];

        return view('flights.payment_confirm', [
            'payment_method' => $request->payment_method ?? 'transfer_bank',
            'booking_code'   => $booking_code,
            'va_number'      => '8277' . rand(100000000, 999999999),
            'total'          => $total,
            'flight'         => $flight,
            'from'           => $from,
            'to'             => $to,
            'from_code'      => $from_code,
            'to_code'        => $to_code,
            'date'           => $request->date ?? '',
            'passengers'     => $passengers,
            'passenger_name' => $passengerName,
        ]);
    }

    public function destinations()
    {
        $destinations = [
            ['DPS', 'Bali', 'Indonesia', 'Rp 450.000', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500&q=80', '🏖️', '#f97316', 'Asia'],
            ['SIN', 'Singapura', 'Singapura', 'Rp 1.200.000', 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=500&q=80', '🌆', '#ef4444', 'Asia'],
            ['KUL', 'Kuala Lumpur', 'Malaysia', 'Rp 980.000', 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=500&q=80', '🏙️', '#3b82f6', 'Asia'],
            ['BKK', 'Bangkok', 'Thailand', 'Rp 1.500.000', 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=500&q=80', '⛩️', '#8b5cf6', 'Asia'],
            ['HND', 'Tokyo', 'Jepang', 'Rp 5.200.000', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=500&q=80', '🗼', '#ec4899', 'Asia'],
            ['ICN', 'Seoul', 'Korea Selatan', 'Rp 4.100.000', 'https://images.unsplash.com/photo-1538485399081-7191377e8241?w=500&q=80', '🏯', '#06b6d4', 'Asia'],
            ['HKG', 'Hong Kong', 'Hong Kong', 'Rp 2.800.000', 'https://images.unsplash.com/photo-1506970845246-18f21d533b21?w=500&q=80', '🌃', '#84cc16', 'Asia'],
            ['SYD', 'Sydney', 'Australia', 'Rp 4.800.000', 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=500&q=80', '🦘', '#14b8a6', 'Australia'],
            ['MEL', 'Melbourne', 'Australia', 'Rp 4.600.000', 'https://images.unsplash.com/photo-1545044846-351ba102b6d5?w=500&q=80', '☕', '#0ea5e9', 'Australia'],
            ['LHR', 'London', 'Inggris', 'Rp 8.500.000', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=500&q=80', '🎡', '#6366f1', 'Eropa'],
            ['CDG', 'Paris', 'Prancis', 'Rp 9.200.000', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500&q=80', '🗼', '#f43f5e', 'Eropa'],
            ['AMS', 'Amsterdam', 'Belanda', 'Rp 8.800.000', 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=500&q=80', '🌷', '#a855f7', 'Eropa'],
            ['DXB', 'Dubai', 'UAE', 'Rp 3.200.000', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=500&q=80', '🏙️', '#f59e0b', 'Timur Tengah'],
            ['DOH', 'Doha', 'Qatar', 'Rp 3.500.000', 'https://images.unsplash.com/photo-1553913861-c0fddf2619ee?w=500&q=80', '🌙', '#10b981', 'Timur Tengah'],
            ['JFK', 'New York', 'Amerika', 'Rp 12.500.000', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=500&q=80', '🗽', '#3b82f6', 'Amerika'],
            ['LAX', 'Los Angeles', 'Amerika', 'Rp 11.800.000', 'https://images.unsplash.com/photo-1534430480872-3498386e7856?w=500&q=80', '🎬', '#f97316', 'Amerika'],
            ['SUB', 'Surabaya', 'Indonesia', 'Rp 380.000', 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=500&q=80', '🦈', '#22c55e', 'Indonesia'],
            ['YOG', 'Yogyakarta', 'Indonesia', 'Rp 320.000', 'https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=500&q=80', '🏛️', '#eab308', 'Indonesia'],
            ['MES', 'Medan', 'Indonesia', 'Rp 520.000', 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=500&q=80', '🌴', '#ef4444', 'Indonesia'],
            ['UPG', 'Makassar', 'Indonesia', 'Rp 680.000', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500&q=80', '🌊', '#06b6d4', 'Indonesia'],
        ];

        return view('destinations', compact('destinations'));
    }

    public function showTicket($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->payment_status !== 'paid') {
            $booking->payment_status = 'paid';
            $booking->save();
        }

        return view('flights.ticket', [
            'booking_code' => $booking->booking_code,
            'flight' => [
                'maskapai'  => $booking->maskapai,
                'kode'      => $booking->kode_penerbangan,
                'berangkat' => $booking->berangkat,
                'tiba'      => $booking->tiba,
                'durasi'    => $booking->durasi,
                'harga'     => 'Rp ' . number_format($booking->harga_tiket, 0, ',', '.'),
                'kelas'     => $booking->kelas,
            ],
            'from'           => $booking->from,
            'to'             => $booking->to,
            'from_code'      => $booking->from_code,
            'to_code'        => $booking->to_code,
            'date'           => $booking->tanggal,
            'passengers'     => $booking->jumlah_penumpang,
            'total'          => 'Rp ' . number_format($booking->total_harga, 0, ',', '.'),
            'passenger_name' => $booking->contact_name ?: (auth()->user()->name ?? 'Penumpang SkyBook'),
        ]);
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.bookings', compact('bookings'));
    }

    public function bookingDetail($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('pages.booking_detail', compact('booking'));
    }

    public function flightStatus(Request $request)
    {
        $keyword = $request->query('keyword');

        $booking = null;

        if ($keyword) {
            $booking = Booking::where('user_id', auth()->id())
                ->where(function ($query) use ($keyword) {
                    $query->where('kode_penerbangan', 'like', '%' . $keyword . '%')
                        ->orWhere('booking_code', 'like', '%' . $keyword . '%');
                })
                ->latest()
                ->first();
        }

        $popularFlights = Booking::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('pages.flight-status', compact('booking', 'popularFlights', 'keyword'));
    }

    public function show($code)
    {
        $flight = Flight::where('kode_penerbangan', $code)->first();

        return view('pages.flight-detail', compact('flight'));
    }
}