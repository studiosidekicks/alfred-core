<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('alfred-assets/js/manifest.js') }}" defer></script>
    <script src="{{ asset('alfred-assets/js/vendor.js') }}" defer></script>
    <script src="{{ asset('alfred-assets/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('alfred-assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
        html, body {margin:0;padding:0;}
        body {font-family: 'Roboto', sans-serif;}
    </style>
</head>
<body>
    <div id="app"></div>
</body>
</html>
