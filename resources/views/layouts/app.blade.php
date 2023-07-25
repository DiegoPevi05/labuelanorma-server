<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app" class="flex flex-row" style="width: 100vw; height: 100vh;">
        @guest
        <div class="flex-grow-1 d-flex flex-column overflow-hidden">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-auto py-4 mx-5">
                    @yield('content')
                </div>
            </div>
        </div>
        @else
        <div class="flex-grow-1 d-flex flex-column overflow-hidden">
            <div class="d-flex">
                <div class="text-white bg-dark" style="width: 280px;">
                    @include('layouts.sidebar')
                </div>
                <div class="flex-grow-1 overflow-auto py-4 mx-5">
                    @yield('content')
                </div>
            </div>
        </div>
        @endguest

    </div>
</body>
</html>
