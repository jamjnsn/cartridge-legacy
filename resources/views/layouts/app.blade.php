<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cartridge</title>

    <script src="{{ mix('app.js') }}" defer></script>
    <link href="{{ mix('app.css') }}" rel="stylesheet">

    <link rel="icon" href="favicon.svg">
</head>
<body>
    <div id="app">
        <nav-bar></nav-bar>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
