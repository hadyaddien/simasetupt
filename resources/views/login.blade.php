<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Simaset UPT</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-cover bg-center flex items-center justify-center px-4"
    style="background-image: url('{{ asset('img/bg.jpg') }}');">
    {{-- <div class="absolute inset-0 bg-black/20"></div> --}}
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
    <main>
        <div
            class="max-w-6xl w-full mx-auto flex flex-col md:flex-row items-center justify-between space-y-10 md:space-y-0 md:space-x-10 pt-20">

            <!-- Left side: Judul Sistem -->
            <div class="text-center md:text-left md:w-1/2">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-2">
                    The Office Assets Management Information System
                </h1>
                <h2 class="text-xl md:text-2xl font-semibold text-white">
                    PT PLN (Persero) UPT Bogor
                </h2>
            </div>

            <!-- Right side: Login Card -->
            <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-[400px]">
                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('img/logo.png') }}" alt="logo PLN" class="w-20 mb-2">
                    <h2 class="text-xl font-semi-bold text-gray-800">Login</h2>
                </div>

                <form action="/login" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 w-full border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-[#125d72]">
                        @error('email')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" name="password" id="password" required
                            class="mt-1 w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-[#125d72]">
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-[#125d72] text-white font-semibold rounded-md hover:bg-[#0e4b5c]">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>



</html>
