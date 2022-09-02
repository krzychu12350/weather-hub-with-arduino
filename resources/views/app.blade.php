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
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <meta name="theme-color" content="#2196F3"/>
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <!-- Orientation  -->
        <meta name="screen-orientation" content="portrait">
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
