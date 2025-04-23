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

<body class="min-h-screen bg-[#fafafa] flex items-center justify-center">
    <div class="p-12 shadow bg-[#ffffff] rounded-md w-[500px]">
        <p class="text-xl font-semibold text-center">SimasetUPT</p>
        <P class="text-2xl font-bold text-center">Sign in</P>
        <form action="/login" method="POST" class="space-y-4 mt-8">
            @csrf
            <div class="flex flex-col space-y-2">
                <label class="text-md text-gray-900">Email address</label>
                <input type="email" name="email" id="email" class="p-2 border border-gray-200 outline-[#D97706] rounded-xl w-full">
            </div>
            <div class="flex flex-col space-y-2">
                <label class="text-md text-gray-900">Password</label>
                <input type="password" name="password" id="password" class="p-2 border border-gray-200  outline-[#D97706]  rounded-xl w-full">
            </div>
            <div>
                <button class="px-5 py-2 rounded-md text-white text-md w-full bg-[#D97706]">Sign
                    In</button>
            </div>
        </form>
    </div>
</body>


</html>
