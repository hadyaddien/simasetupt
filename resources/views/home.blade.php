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
    {{-- <div class="bg-gray-50 text-[#125d72]">
        <!-- Background Image -->
        <img id="background" class="absolute top-0 left-0 w-screen h-auto object-cover -z-10"
            src="{{ asset('img/bg.jpg') }}" alt="UPT Bogor background" />

        <!-- Main Container -->
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#125d72] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <!-- Header -->
                <header class="flex flex-col items-center py-10">
                    <h1 class="text-3xl md:text-5xl font-bold text-black text-center">
                        Assets Management Information System
                    </h1>
                </header>

                <!-- Login Card -->
                <main class="mt-10 flex justify-center">
                    <a href="{{ route('login') }}"
                        class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md hover:text-black/70 transition">

                        <!-- Cover Image -->
                        <img src="{{ asset('img/cover.png') }}" alt="Cover PLN"
                            class="w-full h-auto rounded-lg object-contain" />

                        <!-- Text -->
                        <div>
                            <h2 class="text-xl font-semibold">Unit Pelaksana Transmisi PLN Bogor</h2>
                            <p class="text-lg">Login</p>
                        </div>
                    </a>
                </main>

            </div>
        </div> --}}
    {{-- </div> --}}
    <div class="min-h-screen overflow-hidden flex flex-col items-center justify-center" style="background-image: url({{ asset('img/bg.jpg') }})">
        <h1 class="text-3xl md:text-5xl font-bold text-white text-center">
            Assets Management Information System
        </h1>
        <main class="mt-10 flex justify-center">
            <a href="{{ route('login') }}"
                class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-md hover:text-black/70 transition">

                <!-- Cover Image -->
                <img src="{{ asset('img/cover.png') }}" alt="Cover PLN"
                    class="w-full h-auto rounded-lg object-contain" />

                <!-- Text -->
                <div>
                    <h2 class="text-xl font-semibold">Unit Pelaksana Transmisi PLN Bogor</h2>
                    <p class="text-lg">Login</p>
                </div>
            </a>
        </main>
    </div>
</body>


</html>
