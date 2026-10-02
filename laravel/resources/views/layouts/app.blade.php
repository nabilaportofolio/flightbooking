<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eef3f8] text-slate-900">

<nav class="bg-[#05203c] text-white px-8 py-4 flex justify-between items-center">
    <a href="{{ route('home') }}" class="text-2xl font-bold text-sky-400">SkyBook</a>

    <div class="flex gap-5 text-sm">
        <a href="{{ route('home') }}">Pesan Tiket</a>
        <a href="{{ route('orders') }}">Kelola Pesanan</a>
        <a href="{{ route('checkin') }}">Check-in</a>
        <a href="{{ route('passengers') }}">Data Penumpang</a>
        <a href="{{ route('contact') }}">Kontak</a>
        <a href="{{ route('flight.status') }}">Status</a>
    </div>
</nav>

<main class="max-w-6xl mx-auto py-8">
    @yield('content')
</main>

</body>
</html>