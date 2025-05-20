<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SimasetUPT</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-[#125d72]">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 px-4 py-3 shadow-sm">
        <div class="container mx-auto flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div><img src="{{ asset('img/logo.png') }}" alt="Logo PLN" class="w-1/6"></div>
            {{-- <a href="#" class="text-xl font-semibold text-amber-600">MyApp</a> --}}

            <!-- Tombol hamburger (untuk mobile) -->
            <button id="menu-toggle" class="md:hidden text-gray-600 hover:text-black focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menu -->
            <div id="menu" class="w-full md:flex md:items-center md:w-auto hidden mt-3 md:mt-0">
                <ul class="flex flex-col md:flex-row md:space-x-6">
                    <li><a href="/" class="block text-gray-700 hover:text-[#125d72] py-2">About</a>
                    </li>
                    <li><a href="{{ route('login') }}" class="block text-gray-700 hover:text-[#125d72] py-2">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white px-8 py-40"
        style="background-image: url('{{ asset('img/bg.jpg') }}');">
        <div class="absolute inset-0 bg-black/20"></div> <!-- Optional overlay -->

        <div class="relative text-center z-10">
            <h1 class="text-2xl md:text-3xl font-bold">
                The Office Assets Management Information System
            </h1>
            <h2 class="text-xl mt-2">
                PT PLN (Persero) UPT Bogor
            </h2>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="bg-white px-6 md:px-20 py-10 grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <h3 class="text-lg font-bold mb-4 text-gray-800">About</h3>
            <p class="text-gray-700 mb-4">
                <strong> Office Asset Management Information System </strong> is a web-based platform developed to
                optimize the recording, monitoring, and management of office assets within PT PLN (Persero) UPT
                Bogor. Asset management is one of the essential operational functions of UPT Bogor, responsible for
                maintaining the sustainability and reliability of transmission assets and supporting facilities.
            </p>
            <p class="text-gray-700 mb-4">
                This system was created to replace manual and semi-manual asset management methods, enabling real-time
                data updates, accurate reporting, and centralized asset monitoring. It aims to facilitate easier
                tracking of asset conditions, improve transparency, and speed up decision-making processes.
            </p>
            <p class="text-gray-700">
                By implementing this system, PT PLN (Persero) UPT Bogor aims to improve transparency, minimize asset
                loss risks, and accelerate decision-making processes, contributing to more accountable and effective
                asset management.
            </p>
        </div>
        <div class="space-y-4">
            <div class="w-full h-40 bg-gray-300"></div>
            <div class="w-full h-40 bg-gray-300"></div>
        </div>
    </section>

    {{-- <div class="bg-cover min-h-screen overflow-hidden flex flex-col items-center justify-center"
        style="background-image: url({{ asset('img/bg.jpg') }})">
        <h1 class="text-3xl md:text-5xl font-bold text-white text-center">
            Assets Management Information System
        </h1>
        <main class="mt-10 flex justify-center">
            <a href="{{ route('login') }}"
                class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md hover:text-black/70 transition">

                <!-- Cover Image -->
                <img src="{{ asset('img/logo.png') }}" alt="Logo PLN" class="w-full h-auto rounded-lg object-contain" />

                <!-- Text -->
                <div>
                    <h2 class="text-xl font-semibold">Unit Pelaksana Transmisi PLN Bogor</h2>
                    <p class="text-lg">Login</p>
                </div>
            </a>
        </main>
    </div> --}}
</body>


</html>
