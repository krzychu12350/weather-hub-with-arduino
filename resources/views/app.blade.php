<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- PWA  -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="description" content="The best weather app ever">
        <meta name="keywords" content="weather app">
        <title>{{ config('app.name') }}</title>

        <!-- Startup Image  -->
        <link href="{{ asset('logo.png') }}" rel="apple-touch-startup-image">
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <!-- Orientation  -->
        <meta name="screen-orientation" content="portrait">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="mask-icon" href="{{ asset('favicons/safari-pinned-tab.svg') }}" color="#2d89ef">

        <meta name="apple-mobile-web-app-title" content="Weather Hub">
        <meta name="application-name" content="Weather Hub">
        <meta name="theme-color" content="#2196F3"/>

        <!-- Tile for Win8 -->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('logo.png') }}">

        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <meta name="csrf-token" value="{{ csrf_token() }}" />

        <!-- Fonts
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">-->
        <style>
            #app {
                padding: 0;
                margin: 0;
                width: 100%;
            }
        </style>

        @vite('resources/css/app.css')

    </head>
    <body>
        <div id="app"></div>

        @vite('resources/js/app.js')
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>
