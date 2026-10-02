@extends('layouts.app')

@section('content')
<div class="px-6 py-8">

    <div class="mb-8">
        <p class="text-sm font-semibold text-blue-600">SkyBook Passenger</p>
        <h1 class="text-3xl font-extrabold text-slate-900 mt-1">Data Penumpang</h1>
        <p class="text-slate-500 mt-2">
            Simpan data penumpang agar proses booking berikutnya lebih cepat.
        </p>
    </div>

    <div class="grid grid-cols-12 gap-6">

        <section class="col-span-12 lg:col-span-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-7">

                <h2 class="text-xl font-bold">Informasi Pribadi</h2>
                <p class="text-sm text-slate-500 mt-1 mb-6">
                    Isi data sesuai KTP atau paspor.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="label">Title</label>
                        <select class="field">
                            <option>Pilih title</option>
                            <option>Mr.</option>
                            <option>Mrs.</option>
                            <option>Ms.</option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Jenis Kelamin</label>
                        <select class="field">
                            <option>Pilih jenis kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Nama Depan</label>
                        <input type="text" class="field" placeholder="Nama depan">
                    </div>

                    <div>
                        <label class="label">Nama Belakang</label>
                        <input type="text" class="field" placeholder="Nama belakang">
                    </div>

                    <div>
                        <label class="label">Tanggal Lahir</label>
                        <input type="date" class="field">
                    </div>

                    <div>
                        <label class="label">Kewarganegaraan</label>
                        <input type="text" class="field" placeholder="Contoh: Indonesia">
                    </div>

                </div>

                <hr class="my-7">

                <h2 class="text-xl font-bold">Informasi Identitas</h2>
                <p class="text-sm text-slate-500 mt-1 mb-6">
                    Untuk penerbangan internasional, gunakan data paspor yang masih berlaku.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="label">Jenis Identitas</label>
                        <select class="field">
                            <option>Pilih identitas</option>
                            <option>KTP</option>
                            <option>Paspor</option>
                            <option>SIM</option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Nomor Identitas</label>
                        <input type="text" class="field" placeholder="Nomor KTP/Paspor">
                    </div>

                    <div>
                        <label class="label">Negara Penerbit</label>
                        <input type="text" class="field" placeholder="Contoh: Indonesia">
                    </div>

                    <div>
                        <label class="label">Masa Berlaku</label>
                        <input type="date" class="field">
                    </div>

                </div>

                <hr class="my-7">

                <h2 class="text-xl font-bold">Kontak Darurat</h2>
                <p class="text-sm text-slate-500 mt-1 mb-6">
                    Kontak ini dapat digunakan jika terjadi perubahan jadwal mendadak.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="label">Nama Kontak Darurat</label>
                        <input type="text" class="field" placeholder="Nama keluarga/kerabat">
                    </div>

                    <div>
                        <label class="label">Nomor HP Kontak Darurat</label>
                        <input type="text" class="field" placeholder="08xxxxxxxxxx">
                    </div>

                </div>

                <button class="mt-7 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold">
                    Simpan Data Penumpang
                </button>

            </div>
        </section>

        <aside class="col-span-12 lg:col-span-4">
            <div class="bg-[#05203c] text-white rounded-3xl p-7 shadow-sm">
                <div class="text-4xl mb-4">👤</div>
                <h2 class="text-xl font-bold">Kenapa data ini penting?</h2>
                <p class="text-sm text-blue-100 mt-2">
                    Data penumpang harus sesuai identitas resmi agar tidak bermasalah saat check-in dan boarding.
                </p>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="bg-white/10 rounded-2xl p-4">✅ Mempercepat proses booking</div>
                    <div class="bg-white/10 rounded-2xl p-4">🛂 Dibutuhkan untuk penerbangan internasional</div>
                    <div class="bg-white/10 rounded-2xl p-4">🎫 Digunakan pada e-ticket</div>
                </div>
            </div>
        </aside>

    </div>
</div>

<style>
    .label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .field {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        padding: 13px 16px;
        outline: none;
        background: white;
    }

    .field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
    }
</style>
@endsection