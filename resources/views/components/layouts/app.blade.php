<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') . ' | ' .  ($title ?? 'beranda')  }}</title>
        @vite('resources/css/app.css')
        @livewireStyles
    </head>
    <body>
        @livewire('shared.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('shared.footer')
        @livewireScripts
        @vite('resources/js/app.js')
    </body>
</html>
