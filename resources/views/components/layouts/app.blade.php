<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') . ' | ' .  ($title ?? 'beranda')  }}</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        @vite('resources/css/app.css')
        @livewireStyles
        @filamentStyles
    </head>
    <body class="bg-white  dark:bg-slate-700">

        @livewire('shared.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('shared.footer')
        @livewireScripts
        @filamentScripts
        @vite('resources/js/app.js')

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
    </body>
</html>
