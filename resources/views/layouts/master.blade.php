<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', '@Master Layout'))</title>

        {{-- BS5 --}}
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        @vite(['resources/css/app.css'])
    </head>
    <body>
    
        @yield('content')

        <script src="{{ asset('js/jquery/3.7.1/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery/jquery.validation/jquery.validate.min.js') }}"></script>
        @vite(['resources/js/app.js'])
    </body>
</html>