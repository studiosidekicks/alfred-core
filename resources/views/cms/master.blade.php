<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('alfred-assets/js/manifest.js') }}" defer></script>
    <script src="{{ asset('alfred-assets/js/vendor.js') }}" defer></script>
    <script src="{{ asset('alfred-assets/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <link href="{{ asset('alfred-assets/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app"></div>
</body>
</html>
