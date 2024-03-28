<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', '@Master Layout'))</title>

        {{-- BS5 --}}
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        @vite(['resources/css/app.css', 'resources/css/screens/admin.css'])
    </head>
    <body>
        
        @include('partial.navbar')
        
        <div class="containerAdmin">
            <div class="row gx-0">
                <div class="col-3 bg-light pe-0 pt-4 sidebar">
                    <ul >
                        <li>
                            <a href="/admin/user">Users</a>
                        </li>
                        <li>
                            <a href="/admin/category">Categories</a>
                        </li>
                        <li>
                            <a href="/admin/product">Products</a>
                        </li>
                    </ul>
                </div>
                <div class="col-9 contentAdmin">
                    @yield('content')
                </div>
            </div>
        
        </div>

        <script src="{{ asset('js/jquery/3.7.1/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery/jquery.validation/jquery.validate.min.js') }}"></script>
        @vite(['resources/js/app.js', 'resources/js/screens/admin.js'])
    </body>
</html>