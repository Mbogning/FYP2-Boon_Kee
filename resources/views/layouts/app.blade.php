<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/boonkee-removebg-preview.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/midone.css') }}">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/midone.js') }}" defer></script>

    @yield('head')
</head>

<body class="app">
    {{-- @include('layouts.top-bar') --}}
    {{-- @include('layouts.navigation') --}}

    <div class="fixed min-h-screen min-w-full bg-white z-[99] -mt-5 -mx-8" id="preload">
        <img src="{{ asset('images/Hourglass.gif') }}"
            class="absolute mx-auto translate-x-1/2 translate-y-1/2 top-[40%] left-[45%]" alt="">
    </div>
    
    @yield('sidebar')
    {{ $slot ?? '' }}


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(window).on('load', function() {
            // Animate loader off screen
            $("#preload").fadeOut("fast");
        });

        $(document).ready(function() {
            const route = '{{ URL::current() }}';
            const location = window.location.href;

            if (location == route || location == route + '/') {
                $('a[href="' + route + '"]').addClass('side-menu--active');
                let a_tag = $('a[href="' + route + '"]');

                if (a_tag.parent().parents('ul.sub-menu').length) {
                    a_tag.parent().parent().addClass('side-menu__sub-open');
                    a_tag.parent().parent().parent().find('a.menu-title').addClass('side-menu--active');
                }
            }
        });
    </script>
    @yield('script')
</body>

</html>
