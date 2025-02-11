<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="authentication-bg font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zimc-50/80">
            <div class="flex flex-col items-center text-center">
                <x-app-logo size="h-36 w-36" />
                <h1 class="text-3xl text-slate-600 font-semibold my-5 bg-white/90 p-4">
                    Two Shakes Review
                    <span class="block text-2xl">Admin Portal</span>
                </h1>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <h2 class="text-xl mb-5">Account login</h2>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
