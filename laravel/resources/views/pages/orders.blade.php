@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-8">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-900">
            Cari Pesanan
        </h1>

        <p class="text-slate-500 mt-2">
            Lihat status tiket, pembayaran, e-ticket, dan detail perjalanan Anda.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <label class="block text-sm font-semibold mb-2">
                    Kode Booking
                </label>

                <input type="text"
                       placeholder="Contoh: SKY123456"
                       class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-600">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">
                    Email / Nomor HP
                </label>

                <input type="text"
                       placeholder="email@contoh.com"
                       class="w-full border border-slate-300 rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-600">
            </div>

        </div>

        <button
            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-semibold">
            Cari Pesanan
        </button>

    </div>

    {{-- Contoh hasil pencarian --}}

    <div class="mt-8 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="bg-[#05203c] text-white p-5">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">
                        Jakarta → Bali
                    </h2>

                    <p class="text-blue-100 text-sm">
                        Kode Booking: SKY123456
                    </p>
                </div>

                <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                    Confirmed
                </span>
            </div>
        </div>

        <div class="p-6">

            <div class="grid md:grid-cols-4 gap-6">

                <div>
                    <p class="text-slate-400 text-sm">
                        Penumpang
                    </p>

                    <p class="font-bold">
                        Nabila Husnaini
                    </p>
                </div>

                <div>
                    <p class="text-slate-400 text-sm">
                        Maskapai
                    </p>

                    <p class="font-bold">
                        Garuda Indonesia
                    </p>
                </div>

                <div>
                    <p class="text-slate-400 text-sm">
                        Jadwal
                    </p>

                    <p class="font-bold">
                        16 Juni 2026
                    </p>
                </div>

                <div>
                    <p class="text-slate-400 text-sm">
                        Total
                    </p>

                    <p class="font-bold text-blue-600">
                        Rp 1.449.625
                    </p>
                </div>

            </div>

            <hr class="my-6">

            <div class="grid md:grid-cols-3 gap-4">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-semibold">
                    Lihat E-Ticket
                </button>

                <button
                    class="bg-slate-100 hover:bg-slate-200 py-3 rounded-2xl font-semibold">
                    Detail Pesanan
                </button>

                <button
                    class="bg-slate-100 hover:bg-slate-200 py-3 rounded-2xl font-semibold">
                    Download Invoice
                </button>

            </div>

        </div>

    </div>

</div>

@endsection